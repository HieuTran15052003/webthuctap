<?php
include('../../config/config.php');

// Lấy dữ liệu từ form
$tensanpham = !empty($_POST['tensanpham']) ? trim($_POST['tensanpham']) : null;
$masp = isset($_POST['masp']) ? trim($_POST['masp']) : null;
$giasp = isset($_POST['giasp']) ? trim($_POST['giasp']) : null;
$soluong = isset($_POST['soluong']) ? trim($_POST['soluong']) : null;
$hinhanh = isset($_FILES['hinhanh']['name']) ? $_FILES['hinhanh']['name'] : null;
$hinhanh_tmp = isset($_FILES['hinhanh']['tmp_name']) ? $_FILES['hinhanh']['tmp_name'] : null;
$hinhanh = time().'_'.$hinhanh;
$tomtat = isset($_POST['tomtat']) ? trim($_POST['tomtat']) : null;
$tinhtrang = isset($_POST['tinhtrang']) ? $_POST['tinhtrang'] : '';
$danhmuc = isset($_POST['danhmuc']) ? trim($_POST['danhmuc']) : null; 
if (isset($_POST['themsanpham'])) {
    // Kiểm tra xem tên sản phẩm có hợp lệ không
    if (empty($tensanpham)) {
        die("Tên sản phẩm không được để trống.");
    }
    // Lấy giá trị tình trạng từ form
    $tinhtrang = isset($_POST['tinhtrang']) ? $_POST['tinhtrang'] : '';
    // Kiểm tra tình trạng có lựa chọn không
    try {
        $sql_them = "INSERT INTO product(tensanpham, masp, giasp, soluong, hinhanh, tomtat, tinhtrang, id) 
        VALUES (:tensanpham, :masp, :giasp, :soluong, :hinhanh, :tomtat, :tinhtrang, :id)";

        $stmt = $conn->prepare($sql_them);
        $stmt->bindParam(':tensanpham', $tensanpham);
        $stmt->bindParam(':masp', $masp);
        $stmt->bindParam(':giasp', $giasp);
        $stmt->bindParam(':soluong', $soluong);
        $stmt->bindParam(':hinhanh', $hinhanh);
        $stmt->bindParam(':tomtat', $tomtat);
        $stmt->bindParam(':tinhtrang', $tinhtrang);
        $stmt->bindParam(':id', $danhmuc); // Đổi tên tham số từ :danhmuc thành :id
        
        $stmt->execute();   

        // Di chuyển hình ảnh đã tải lên
        if ($hinhanh_tmp) {
            move_uploaded_file($hinhanh_tmp, 'uploads/'.$hinhanh);
        }

        header('Location: ../../indexad.php?action=product_management&query=more');
        exit;
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}elseif (isset($_POST['suasanpham'])) {
    $id_sanpham = isset($_GET['idsanpham']) ? $_GET['idsanpham'] : null;
    
    if (!$id_sanpham) {
        die("Không tìm thấy ID sản phẩm");
    }

    try {
        // Kiểm tra xem có upload ảnh mới không
        $is_image_uploaded = !empty($_FILES['hinhanh']['name']);
        
        if ($is_image_uploaded) {
            // Xử lý upload ảnh mới
            if (!move_uploaded_file($hinhanh_tmp, 'uploads/'.$hinhanh)) {
                die("Không thể upload ảnh");
            }
            
            // Xóa ảnh cũ
            $stmt = $conn->prepare("SELECT hinhanh FROM product WHERE id_sanpham = ?");
            $stmt->execute([$id_sanpham]);
            $old_image = $stmt->fetchColumn();
            
            if ($old_image && file_exists('uploads/'.$old_image)) {
                unlink('uploads/'.$old_image);
            }
        }

        // Cập nhật thông tin sản phẩm
        $sql_update = "UPDATE product SET   
        tensanpham = :tensanpham,  
        masp = :masp,  
        giasp = :giasp,  
        soluong = :soluong,  
        " . ($is_image_uploaded ? "hinhanh = :hinhanh," : "") . "  
        tomtat = :tomtat,  
        tinhtrang = :tinhtrang,
        id = :id  
        WHERE id_sanpham = :id_sanpham";    
        $stmt = $conn->prepare($sql_update);
        
        $params = [  
            ':tensanpham' => $tensanpham,  
            ':masp' => $masp,  
            ':giasp' => $giasp,  
            ':soluong' => $soluong,  
            ':tomtat' => $tomtat,  
            ':tinhtrang' => $tinhtrang,
            ':id' => $danhmuc,  
            ':id_sanpham' => $id_sanpham  
        ];  
        print_r($params);  
        if ($is_image_uploaded) {  
            $params[':hinhanh'] = $hinhanh; // Chỉ thêm tham số nếu ảnh được tải lên  
        }  

        if ($stmt->execute($params)) {
            // Redirect only if update was successful
            header('Location: ../../indexad.php?action=product_management&query=more');
            exit();
        } else {
            die("Cập nhật không thành công");
        }
        
    } catch (PDOException $e) {
        die("Lỗi: " . $e->getMessage());
    }
} else {  
    $id = $_GET['idsanpham'];  
    try {  
        $sql = "SELECT * FROM product WHERE id_sanpham = :id_sanpham LIMIT 1";  
        $stmt = $conn->prepare($sql);  
        $stmt->bindParam(':id_sanpham', $id, PDO::PARAM_INT);  
        $stmt->execute();  
        $row = $stmt->fetch(PDO::FETCH_ASSOC);  

        if ($row) {  
            unlink('uploads/'.$row['hinhanh']);  
        }  

        $sql_xoa = "DELETE FROM product WHERE id_sanpham = :id_sanpham";  
        $stmt = $conn->prepare($sql_xoa);  
        $stmt->bindParam(':id_sanpham', $id, PDO::PARAM_INT);  
        $stmt->execute();  

        header('Location: ../../indexad.php?action=product_management&query=more');  
    } catch (PDOException $e) {  
        echo "Lỗi: " . $e->getMessage();  
    }  
}  
?>