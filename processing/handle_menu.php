<?php  
    // Kiểm tra kết nối
    if (!$mysqli) {
        die("Kết nối database thất bại: " . mysqli_connect_error());
    }
    
    $sql_danhmuc = "SELECT * FROM product_catelog ORDER BY id DESC";  
    $result = $mysqli->query($sql_danhmuc); 
    
    if (!$result) {
        error_log("Lỗi truy vấn SQL: " . $mysqli->error);
        // Có thể hiển thị thông báo lỗi cho người dùng
        // hoặc xử lý theo cách khác
    } 
?> 
<?php  
if (isset($_GET['log_out']) && $_GET['log_out'] == 1) {
    // Bắt đầu session nếu chưa có
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Lưu lại giỏ hàng trước khi hủy session
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    // Hủy toàn bộ session
    session_unset();     // Xóa tất cả các biến session
    session_destroy();   // Hủy session

    // Bắt đầu lại session để giữ giỏ hàng
    session_start();
    $_SESSION['cart'] = $cart;  

    // Chuyển hướng về trang chính
    header('Location: index.php');
    exit();
}
?>
