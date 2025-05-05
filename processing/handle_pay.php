<!-------
Thanh toán vnpay
tk:abcdfbbb@gmail.com
mk:Hieu1505
----->
<?php
    session_start(); // Đảm bảo session được bật
    // Kiểm tra đường dẫn tuyệt đối đến file config
    include('../admin/config/config.php');
    include('order_mail.php');
    include('../vendor/autoload.php');
    include('../processing/config_vnpay.php');
    // Kiểm tra token ngay đầu file
    if (isset($_POST['order_token']) && $_POST['order_token'] === $_SESSION['order_token']) {
        // Tiến hành xử lý thanh toán
        unset($_SESSION['order_token']); // Hủy token sau khi sử dụng
    }
     // Kiểm tra đăng nhập
     if (!isset($_SESSION['id_khachhang'])) {
        header('Location:../index.php?management=log_in');
        exit();
    }

    use Carbon\Carbon;
    use Carbon\CarbonInterval;
     
    $now = Carbon::now('Asia/Ho_Chi_Minh');

    // Lấy thông tin khách hàng
    $id_khachhang = $_SESSION['id_khachhang'];
    $code_order = sprintf("%06d", mt_rand(1, 999999));
    $cart_payment = $_POST['payment'];

    // Lấy thông tin vận chuyển
    $sql_get_vanchuyen = mysqli_query($mysqli,"SELECT * FROM shipping WHERE id_dangky = '$id_khachhang' LIMIT 1");
    $row_get_vanchuyen = mysqli_fetch_array($sql_get_vanchuyen);
    $id_shipping = $row_get_vanchuyen['id_shipping'];

    //Tính tổng tiền
    $tongtien = 0;
    foreach ($_SESSION['cart'] as $key => $value){
        $thanhtien = $value['soluong_buy'] * $value['giasp'];
        $tongtien += $thanhtien;
    }
    //Insert đơn hàng
    if($cart_payment == 'tienmat'){
        // Thanh toán thường
        $insert_cart = "INSERT INTO cart(id_khachhang, code_cart, cart_status, cart_date, cart_payment, cart_shipping) 
                        VALUES ('".$id_khachhang."','".$code_order."',1,'".$now."','".$cart_payment."','".$id_shipping."')";
        $cart_query = mysqli_query($mysqli,$insert_cart);
        
        // Thêm chi tiết đơn hàng
        foreach ($_SESSION['cart'] as $key => $value) {
            $id_sanpham = $value['id'];
            $soluong = $value['soluong_buy'];
            $insert_cart_details = "INSERT INTO cart_details (id_sanpham, code_cart, soluong_buy) 
                                    VALUES ('".$id_sanpham."', '".$code_order."', '".$soluong."')";
            mysqli_query($mysqli, $insert_cart_details);
            //quản lý số lượng sản phẩm
            $sql_chitiet = "SELECT * FROM product WHERE product.id_sanpham='$id_sanpham' LIMIT 1";
            $query_chitiet = mysqli_query($mysqli,$sql_chitiet);
            while($row_chitiet=mysqli_fetch_array($query_chitiet)){
                $soluongtong = $row_chitiet['soluong'];
                $soluongcon = $row_chitiet['soluong']-$soluong;
                $soluongbanra = $soluong+$row_chitiet['soluongban'];
            }  
            //update lại số lượng 
            $sql_update_sl = "UPDATE product SET soluong='".$soluongcon."',soluongban='".$soluongbanra."' WHERE id_sanpham='$id_sanpham'";
            mysqli_query($mysqli, $sql_update_sl);
        }
        //chuyển hướng
        header('Location: ../index.php?management=thanks&pay=tienmat');
    }elseif($cart_payment == 'vnpay') {
        $vnp_TxnRef = $code_order; 
        $vnp_OrderInfo = 'Thanh toán đơn hàng đặt tại website';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $tongtien * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $vnp_ExpireDate = $expire;
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate"=>$vnp_ExpireDate
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        // }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $_SESSION['pending_cart'] = json_encode([
            'id_khachhang' => $id_khachhang,
            'code_cart' => $code_order,
            'cart_status' => 1,
            'cart_date' => $now->format('Y-m-d H:i:s'), // Chuyển về chuỗi
            'cart_payment' => $cart_payment,
            'cart_shipping' => $id_shipping,
            'cart_items' => $_SESSION['cart']
        ]);
        // Xóa giỏ hàng nhưng KHÔNG lưu vào database ngay lập tức
        header('Location: ' . $vnp_Url);
        die();
    }
    if($cart_query){
        $tieude = "Đặt hàng website shopphukiendienthoai.net thành công!";
        // Khởi tạo biến để lưu chi tiết sản phẩm
        $chiTietSanPham = '';
        $tongTien = 0;
        // Tạo chi tiết sản phẩm
        foreach ($_SESSION['cart'] as $key => $item) {
            $thanhTien = $item['soluong_buy'] * $item['giasp'];
            $tongTien += $thanhTien;
            $chiTietSanPham .= "
                <ul style=' font-family: \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;
                            max-width: 400px;
                            background-color: #f8f9fa;
                            border-radius: 8px;
                            padding: 15px 20px;
                            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                            border: 1px solid #e0e0e0;
                '>
                    <li style='margin-bottom: 10px;
                            padding-bottom: 10px;
                            border-bottom: 1px solid #e0e0e0;
                            color: #3366ff;
                            font-weight: 600;
                    '>Tên sản phẩm:{$item['tensanpham']}</li>
                    <li style='margin-bottom: 10px;
                            padding-bottom: 10px;
                            border-bottom: 1px solid #e0e0e0;
                            color: #ff0000;
                    '>Mã sản phẩm: {$item['masp']}</li>
                    <li style='margin-bottom: 10px;
                        padding-bottom: 10px;
                        border-bottom: 1px solid #e0e0e0;
                        color: #cc0099;
                        font-weight: bold;
                    '>Giá: " . number_format($item['giasp'], 0, ',', '.') . "VNĐ</li>
                    <li style='margin-bottom: 10px;
                            padding-bottom: 10px;
                            color: #00b300;
                            font-weight: bold;
                            border-bottom: 1px solid #e0e0e0;
                    '>Số lượng mua: {$item['soluong_buy']}</li>
                    <li style='color: #e62e00;
                            font-weight: bold;
                    '>Thành tiền: " . number_format($thanhTien, 0, ',', '.') . " VNĐ</li>
                </ul>   
            ";
        }
        // Tạo nội dung email hoàn chỉnh
        $noidung = "
            <div style='font-family: Arial, sans-serif;'>
                <p>Cảm ơn quý khách đã đặt hàng của chúng tôi với mã đơn hàng: <strong>$code_order</strong></p>
                <p>Chi tiết đơn hàng:</p>
                $chiTietSanPham
                <p><strong>Tổng tiền: " . number_format($tongTien, 0, ',', '.') . " VNĐ</strong></p>
                <p>Shop sẽ liên hệ quý khách qua số điện thoại về mọi thông tin chi tiết. Sản phẩm sẽ được giao đến tay khách hàng trong thời gian sớm nhất. Cảm ơn quý khách vì đã mua hàng của chúng tôi!</p>
            </div>
        ";
        $maildathang = $_SESSION['email'];
        $mail = new Mailer();
        $mail->order_mail($tieude,$noidung,$maildathang);
        unset($_SESSION['cart']);
        session_write_close();
    }
?>