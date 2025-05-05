<?php  
// Kết nối cơ sở dữ liệu
include('../admin/config/config.php'); 

// Kiểm tra xem có mã đơn hàng không
if (isset($_GET['code']) && is_numeric($_GET['code'])) {
    $code_cart = $_GET['code'];  

    try {   
        // Truy vấn DELETE sử dụng prepared statement để tránh SQL Injection
        $sql_xoa = "DELETE FROM cart WHERE code_cart = :code_cart";  
        $stmt = $conn->prepare($sql_xoa);  
        $stmt->bindParam(':code_cart', $code_cart, PDO::PARAM_INT);
        $stmt->execute();  

        // Truy vấn DELETE sử dụng prepared statement để tránh SQL Injection
        $sql_xoa = "DELETE FROM cart_details WHERE code_cart = :code_cart";  
        $stmt = $conn->prepare($sql_xoa);  
        $stmt->bindParam(':code_cart', $code_cart, PDO::PARAM_INT);
        $stmt->execute();  
        
        // Chuyển hướng về trang lịch sử đơn hàng
        header('Location: http://localhost/webthuctap/index.php?management=order_history');  
        exit(); // Đảm bảo dừng script sau khi chuyển hướng
    } catch (PDOException $e) {  
        echo "Lỗi: " . $e->getMessage();  
    } 
} else {
    echo "Mã đơn hàng không hợp lệ!";
}
?>
