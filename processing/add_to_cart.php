<?php  
session_start();  
include('../admin/config/config.php');
//Cộng sản phẩm
if(isset($_GET['cong'])) {  
    $id =  $_GET['cong'];
    foreach($_SESSION['cart'] as $cart_item) {  
        //nếu dữ liệu trùng 
        if($cart_item['id'] != $id) {  
            $product[] = array(  
                'tensanpham' => $cart_item['tensanpham'],   
                'id' => $cart_item['id'],   
                'soluong_buy' => $cart_item['soluong_buy'],   
                'giasp' => $cart_item['giasp'],   
                'hinhanh' => $cart_item['hinhanh'],   
                'masp' => $cart_item['masp']  
            ); 
            $_SESSION['cart'] = $product; 
        }else{
            $tangsoluong = $cart_item['soluong_buy'] + 1;
            if($cart_item['soluong_buy']<=9){
                $product[] = array(  
                    'tensanpham' => $cart_item['tensanpham'],   
                    'id' => $cart_item['id'],   
                    'soluong_buy' => $tangsoluong,   
                    'giasp' => $cart_item['giasp'],   
                    'hinhanh' => $cart_item['hinhanh'],   
                    'masp' => $cart_item['masp']  
                );
            } else{
                $product[] = array(  
                    'tensanpham' => $cart_item['tensanpham'],   
                    'id' => $cart_item['id'],   
                    'soluong_buy' => $cart_item['soluong_buy'],   
                    'giasp' => $cart_item['giasp'],   
                    'hinhanh' => $cart_item['hinhanh'],   
                    'masp' => $cart_item['masp']  
                ); 
            }
            $_SESSION['cart'] = $product;
        }   
    } 
    header('Location:../index.php?management=shopping_cart');
}
//Trừ sản phẩm
if(isset($_GET['tru'])) {  
    $id =  $_GET['tru'];
    foreach($_SESSION['cart'] as $cart_item) {  
        //nếu dữ liệu trùng 
        if($cart_item['id'] != $id) {  
            $product[] = array(  
                'tensanpham' => $cart_item['tensanpham'],   
                'id' => $cart_item['id'],   
                'soluong_buy' => $cart_item['soluong_buy'],   
                'giasp' => $cart_item['giasp'],   
                'hinhanh' => $cart_item['hinhanh'],   
                'masp' => $cart_item['masp']  
            ); 
            $_SESSION['cart'] = $product; 
        }else{
            $giamsoluong = $cart_item['soluong_buy'] - 1;
            if($cart_item['soluong_buy']>1){
                $giamsoluong = $cart_item['soluong_buy'] - 1;
                $product[] = array(  
                    'tensanpham' => $cart_item['tensanpham'],   
                    'id' => $cart_item['id'],   
                    'soluong_buy' => $giamsoluong,   
                    'giasp' => $cart_item['giasp'],   
                    'hinhanh' => $cart_item['hinhanh'],   
                    'masp' => $cart_item['masp']  
                );
            } else{
                $product[] = array(  
                    'tensanpham' => $cart_item['tensanpham'],   
                    'id' => $cart_item['id'],   
                    'soluong_buy' => $cart_item['soluong_buy'],   
                    'giasp' => $cart_item['giasp'],   
                    'hinhanh' => $cart_item['hinhanh'],   
                    'masp' => $cart_item['masp']  
                ); 
            }
            $_SESSION['cart'] = $product;
        }   
    } 
    header('Location:../index.php?management=shopping_cart');
}
//Xóa sản phẩm
if(isset($_SESSION['cart']) && isset($_GET['xoa'])) {  
    $id =  $_GET['xoa'];
    foreach($_SESSION['cart'] as $cart_item) {  
        if($cart_item['id'] != $id) {  
            $product[] = array(  
                'tensanpham' => $cart_item['tensanpham'],   
                'id' => $cart_item['id'],   
                'soluong_buy' => $cart_item['soluong_buy'],   
                'giasp' => $cart_item['giasp'],   
                'hinhanh' => $cart_item['hinhanh'],   
                'masp' => $cart_item['masp']  
            );  
        } 
    $_SESSION['cart'] = $product;
    header('Location:../index.php?management=shopping_cart');  
    } 
}
//Xóa tất cả sản phẩm trong giỏ hàng
if(isset($_GET['xoatatca']) && $_GET['xoatatca']==1) {  
    unset($_SESSION['cart']);
    header('Location:../index.php?management=shopping_cart');  
}
//thêm sản phẩm vào giỏ hàng
if(isset($_POST['themgiohang'])) {  
    //session_destroy();
    // Debug toàn bộ quá trình  
    error_reporting(E_ALL);  
    ini_set('display_errors', 1);  

    $id = $_GET['idsanpham'];  
    $soluong = 1;  

    // Kiểm tra kết nối  
    if (!$mysqli) {  
        die("Kết nối CSDL thất bại: " . mysqli_connect_error());  
    }  

    $sql = "SELECT * FROM product WHERE id_sanpham='".$id."' LIMIT 1 ";  
    $query = mysqli_query($mysqli, $sql);  
    
    if (!$query) {  
        echo "Lỗi truy vấn: " . mysqli_error($mysqli);  
        exit;  
    }  

    $row = mysqli_fetch_array($query);  
    
    if($row) {  
        $new_product = array(array(  
            'tensanpham' => $row['tensanpham'],   
            'id' => $id,   
            'soluong_buy' => $soluong,   
            'giasp' => $row['giasp'],   
            'hinhanh' => $row['hinhanh'],   
            'masp' => $row['masp']  
        ));  

        if(isset($_SESSION['cart'])) {  
            $found = false;  
            $product = []; // Khởi tạo mảng product  
            
            foreach($_SESSION['cart'] as $cart_item) {  
                //nếu dữ liệu trùng 
                if($cart_item['id'] == $id) {  
                    $product[] = array(  
                        'tensanpham' => $cart_item['tensanpham'],   
                        'id' => $cart_item['id'],   
                        'soluong_buy' => $cart_item['soluong_buy'] + 1,   
                        'giasp' => $cart_item['giasp'],   
                        'hinhanh' => $cart_item['hinhanh'],   
                        'masp' => $cart_item['masp']  
                    );  
                    $found = true;  
                } else { 
                    //nếu dữ liệu không trùng 
                    $product[] = $cart_item;  
                }  
            }  
            
            if($found == false) {  
                //liên kết dữ liệu new_product với product
                $product[] = $new_product[0];  
            }  
            
            $_SESSION['cart'] = $product;  
        } else {  
            $_SESSION['cart'] = $new_product;  
        }  
    } 
    header('Location:../index.php?management=shopping_cart');    
}  
?>