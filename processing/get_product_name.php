<?php
include('../admin/config/config.php'); // Kết nối đến cơ sở dữ liệu

try {
    // Lấy tham số ID từ query string
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Kiểm tra nếu ID hợp lệ
    if ($id > 0) {
        // Chuẩn bị câu lệnh SQL
        $sql = "SELECT tensanpham FROM product WHERE id_sanpham = :id"; 
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Lấy kết quả
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Trả về tên sản phẩm dưới dạng JSON
            echo json_encode(["tensanpham" => $row['tensanpham']]);
        } else {
            echo json_encode(["tensanpham" => "Sản phẩm không xác định"]);
        }
    } else {
        // Trường hợp ID không hợp lệ
        echo json_encode(["tensanpham" => "Sản phẩm không xác định"]);
    }
} catch (PDOException $e) {
    // Xử lý lỗi kết nối cơ sở dữ liệu
    echo json_encode(["tensanpham" => "Lỗi kết nối cơ sở dữ liệu"]);
}
?>
