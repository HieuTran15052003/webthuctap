<?php  
// Giả sử bạn đã bao gồm tệp config.php với kết nối PDO ở đó  
include('config/config.php');  

try {  
    // Câu truy vấn SQL  
    $spl_lietke_danhmucsp = "SELECT * FROM product_catelog ORDER BY id DESC";  

    // Chuẩn bị câu truy vấn  
    $stmt = $conn->prepare($spl_lietke_danhmucsp);  
    
    // Thực thi câu truy vấn  
    $stmt->execute();  

    // Lấy tất cả kết quả  
    $query_lietke_danhmucsp = $stmt->fetchAll(PDO::FETCH_ASSOC);  
} catch (PDOException $e) {  
    echo "Lỗi: " . $e->getMessage(); // Hiển thị lỗi nếu có  
}  
?>  

<div class="category-container">
    <div class="header-actions mb-3">
        <h2 class="d-inline-block">Liệt kê danh mục sản phẩm</h2>
        <button type="button" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <span class="icon-plus"><i class="fas fa-plus"></i></span>
            <span class="button-text">Thêm danh mục sản phẩm</span>
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Quản lý</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($query_lietke_danhmucsp as $row) {
                    $i++;
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($row['ten']); ?></td>
                        <td class="action-buttons">
                            <a href="?action=manage_product_catalog&query=fix&id=<?php echo $row['id']; ?>" 
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <a href="modules/manage_product_catalog/handle.php?query=xoa&id=<?php echo $row['id']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php include('modules/manage_product_catalog/more.php'); ?>
