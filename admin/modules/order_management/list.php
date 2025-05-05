<?php  
// Giả sử bạn đã bao gồm tệp config.php với kết nối PDO ở đó  
include('config/config.php');  

try {  
    // Câu truy vấn SQL  
    $spl_lietke_dh = "SELECT * FROM cart,users WHERE cart.id_khachhang=users.id ORDER BY cart.id_cart DESC";  

    // Chuẩn bị câu truy vấn  
    $stmt = $conn->prepare($spl_lietke_dh);  
    
    // Thực thi câu truy vấn  
    $stmt->execute();  

    // Lấy tất cả kết quả  
    $query_lietke_dh = $stmt->fetchAll(PDO::FETCH_ASSOC);  
} catch (PDOException $e) {  
    echo "Lỗi: " . $e->getMessage(); // Hiển thị lỗi nếu có  
}  
?>  

<p>Liệt kê đơn hàng</p>  
<div class="table-responsive">
    <table border="1" width="100%" style="border-collapse:collapse;">  
        <tr>  
            <th>ID</th>  
            <th>Mã đơn hàng</th>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Tình trạng</th> 
            <th>Ngày đặt</th>     
            <th>Quản lý</th>
            <th>Thao tác</th>
        </tr>  
        <?php  
        $i = 0;  
        foreach ($query_lietke_dh as $row) {  
            $i++;  
        ?>  
            <tr>  
                <td><?php echo $i; ?></td>  
                <td><?php echo htmlspecialchars($row['code_cart']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td> 
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td>  
                    <?php 
                        if($row['cart_status'] == 1 ) {
                            echo '<span style="color:green">Đơn hàng mới</span>';
                        }else if($row['cart_status'] == 2 ){
                            echo '<span style="color:blue">Đang vận chuyển</span>';
                        }else if($row['cart_status'] == 3 ){
                            echo '<span style="color:red">Xác nhận đã nhận hàng</span>';
                        }
                    ?>
                </td> 
                <td><?php echo htmlspecialchars($row['cart_date']); ?></td>
                <td>  
                    <a href="indexad.php?action=order&query=view_order&code=<?php echo $row['code_cart'];?>">Xem đơn hàng</a>
                </td> 
                <td>  
                    <a href="modules/order_management/print_order.php?code=<?php echo $row['code_cart'];?>">In đơn hàng</a>
                </td>
            </tr>  
        <?php  
        }  
        ?>  
    </table>
</div>