<?php
    include('../admin/config/config.php');

    try {
        // Lấy tham số ID từ query string
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Kiểm tra nếu ID hợp lệ
        if ($id > 0) {
            // Chuẩn bị câu lệnh SQL
            $sql = "SELECT ten FROM product_catelog WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Lấy kết quả
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Trả về tên danh mục dưới dạng JSON
                echo json_encode(["ten" => $row['ten']]);
            } else {
                echo json_encode(["ten" => "Danh mục không xác định"]);
            }
        } else {
            echo json_encode(["ten" => "Danh mục không xác định"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["ten" => "Lỗi kết nối cơ sở dữ liệu"]);
    }
?>
