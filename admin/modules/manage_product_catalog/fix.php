<?php
// Giả sử bạn đã bao gồm tệp config.php với kết nối PDO ở đó
include('config/config.php');

try {
    // Kiểm tra và lấy ID một cách an toàn
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception("ID không hợp lệ");
    }
    $id = (int)$_GET['id'];
    
    // Câu truy vấn SQL sử dụng prepared statement
    $sql_sua_danhmucsp = "SELECT * FROM product_catelog WHERE id = :id LIMIT 1";
    
    // Chuẩn bị câu truy vấn
    $stmt = $conn->prepare($sql_sua_danhmucsp);
    
    // Bind tham số
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    // Thực thi câu truy vấn
    $stmt->execute();
    
    // Lấy kết quả
    $query_sua_danhmucsp = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Kiểm tra xem có dữ liệu không
    if (!$query_sua_danhmucsp) {
        throw new Exception("Không tìm thấy danh mục");
    }
    
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
    exit();
}
?>

<div class="edit-form">
    <h2>Sửa danh mục sản phẩm</h2>
    
    <div class="form-responsive">
        <form method="POST" action="modules/manage_product_catalog/handle.php?id=<?php echo $_GET['id']?>">
            <table border="1" width="100%" style="border-collapse: collapse;">
                <tr>
                    <td><label for="tendanhmuc">Tên danh mục</label></td>
                    <td><input type="text" id="tendanhmuc" name="tendanhmuc" size="30"
                               value="<?php echo htmlspecialchars($query_sua_danhmucsp['ten']); ?>" required></td>
                </tr>
                <tr>
                    <td colspan="1">
                        <div class="note">Vui lòng nhập đầy đủ trước khi sửa danh mục</div>
                        <input type="hidden" name="id"  value="<?php echo htmlspecialchars($query_sua_danhmucsp['id']); ?>">
                    </td>
                    <td><input type="submit" name="suadanhmuc" value="Sửa danh mục sản phẩm"></td>
                </tr>
            </table>
        </form>
    </div>
</div>