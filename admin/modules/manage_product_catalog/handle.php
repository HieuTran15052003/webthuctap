<?php  
include('../../config/config.php');  
// Lấy dữ liệu từ form  
$tenloaisp = $_POST['tendanhmuc'];    

if (isset($_POST['themdanhmuc'])) {  
    // Kiểm tra dữ liệu đầu vào  
    if (!empty($tenloaisp)) {  
        try {  
            // Câu truy vấn SQL  
            $sql_them = "INSERT INTO product_catelog(ten) VALUES (:tenloaisp)";  
            
            // Chuẩn bị câu truy vấn  
            $stmt = $conn->prepare($sql_them);  
            $stmt->bindParam(':tenloaisp', $tenloaisp);  
            
            // Thực thi câu truy vấn  
            $stmt->execute();  

            header('Location: ../../indexad.php?action=manage_product_catalog&query=more');  
            exit;  
        } catch (PDOException $e) {  
            echo "Lỗi: " . $e->getMessage();  
        }  
    } else {  
        header('Location: ../../indexad.php?action=manage_product_catalog&query=more');  
    }  
} elseif (isset($_POST['suadanhmuc'])) {  
    // Xử lý sửa danh mục  
    if (!empty($tenloaisp) && isset($_GET['id']) && is_numeric($_GET['id'])) {  
        try {  
            $sql_update = "UPDATE product_catelog SET ten = :tenloaisp WHERE id = :id";  
            $stmt = $conn->prepare($sql_update);  
            $stmt->bindParam(':tenloaisp', $tenloaisp);  
            $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);  
            
            $stmt->execute();  
            header('Location: ../../indexad.php?action=manage_product_catalog&query=more');  
            exit;  
        } catch (PDOException $e) {  
            echo "Lỗi: " . $e->getMessage();  
        }  
    } else {  
        header('Location: ../../indexad.php?action=manage_product_catalog&query=more');  
    }  
} elseif (isset($_GET['query']) && $_GET['query'] == 'xoa') {  
    // Đảm bảo có ID khi xóa  
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {  
        $id = $_GET['id'];  
        try {  
            $sql_xoa = "DELETE FROM product_catelog WHERE id = :id";  
            $stmt = $conn->prepare($sql_xoa);  
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);  
            $stmt->execute();  
            header('Location: ../../indexad.php?action=manage_product_catalog&query=more');  
            exit;  
        } catch (PDOException $e) {  
            echo "Lỗi: " . $e->getMessage();  
        }  
    } else {  
        header('Location: ../../indexad.php?action=manage_product_catalog&query=more');  
        exit;  
    }  
}  
?>