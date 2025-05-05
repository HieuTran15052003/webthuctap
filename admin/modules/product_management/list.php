<?php  
include('config/config.php');  

try {  
    // Sửa lại tên bảng từ category thành product_catelog
    $sql_lietke_sp = "SELECT p.*, pc.ten
                      FROM product p
                      LEFT JOIN product_catelog pc ON p.id = pc.id 
                      ORDER BY p.id_sanpham DESC";

    // Chuẩn bị câu truy vấn  
    $stmt = $conn->prepare($sql_lietke_sp);  
    
    // Thực thi câu truy vấn  
    $stmt->execute();  

    // Lấy tất cả kết quả  
    $query_lietke_sp = $stmt->fetchAll(PDO::FETCH_ASSOC);  
} catch (PDOException $e) {  
    echo "Lỗi: " . $e->getMessage();  
    die();
}  
?>  
<div class="category-container">
    <div class="header-actions mb-3">
    <h2 class="d-inline-block">Liệt kê sản phẩm</h2>
    <button type="button" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addProductModal">
        <span class="icon-plus"><i class="fas fa-plus"></i></span>
        <span class="button-text">Thêm sản phẩm</span>
    </button>
    </div>
    <div class="table-responsive">  
        <table class="table table-bordered table-hover"> 
            <thead class="thead-dark"> 
                <tr>  
                    <th>ID</th>  
                    <th>Tên sản phẩm</th>  
                    <th>Hình ảnh</th>  
                    <th>Giá sản phẩm</th>  
                    <th>Số lượng kho</th>
                    <th>Số lượng bán</th>
                    <th>Danh mục</th>  
                    <th>Mã sản phẩm</th>  
                    <th>Tóm tắt</th>  
                    <th>Tình trạng</th>
                    <th>Quản lý</th>    
                </tr>
            </thead>  
            <tbody>  
                <?php  
                $i = 0;  
                if(!empty($query_lietke_sp)) {
                    foreach ($query_lietke_sp as $row) {  
                        $i++;  
                ?>  
                    <tr>  
                        <td><?php echo $i; ?></td>  
                        <td><?php echo htmlspecialchars($row['tensanpham']); ?></td>
                        <td><img src="modules/product_management/uploads/<?php echo htmlspecialchars($row['hinhanh']); ?>" width="150px" class="img-fluid"></td>
                        <td><?php echo number_format($row['giasp'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($row['soluong']); ?></td>
                        <td><?php echo htmlspecialchars($row['soluongban']); ?></td>
                        <td><?php echo htmlspecialchars($row['ten'] ?? 'Không có danh mục'); ?></td>
                        <td><?php echo htmlspecialchars($row['masp']); ?></td>
                        <td><?php echo htmlspecialchars($row['tomtat']); ?></td>
                        <td>
                            <?php  
                            echo $row['tinhtrang'] == 1 ? 'Kích hoạt' : 'Ẩn';  
                            ?>
                        </td>
                        <td class="action-buttons">
                            <a class="btn btn-sm btn-danger"
                            onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')" 
                            href="modules/product_management/handle.php?idsanpham=<?php echo $row['id_sanpham']; ?>"><i class="fas fa-trash"></i>Xóa</a>
                            <a class="btn btn-sm btn-warning" 
                            href="?action=product_management&query=fix&idsanpham=<?php echo $row['id_sanpham']; ?>"><i class="fas fa-edit"></i>Sửa</a>
                        </td>
                    </tr>  
                <?php  
                    }  
                }  
                ?>  
            </tbody>
        </table>
    </div>
</div>
<?php
// Hàm tạo mã sản phẩm ngẫu nhiên và kiểm tra trùng lặp
function generateUniqueCode($conn) {
    do {
        // Tạo mã ngẫu nhiên gồm 6 chữ số
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Chuẩn bị câu truy vấn để kiểm tra mã
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM product WHERE masp = :masp");
        $stmt->bindParam(':masp', $code);
        $stmt->execute();

        // Lấy kết quả kiểm tra
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Nếu mã chưa tồn tại, thoát khỏi vòng lặp
    } while ($row['count'] > 0);

    return $code;
}

// Gọi hàm để tạo mã sản phẩm duy nhất
$masp = generateUniqueCode($conn);
?>
<!-- Modal Thêm sản phẩm -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Thêm modal-lg để modal rộng hơn -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form method="POST" action="modules/product_management/handle.php" enctype="multipart/form-data">
            <div class="modal-body">
                <!-- Thông tin cơ bản -->
                <div class="mb-3 row">
                    <label for="tensanpham" class="col-sm-3 col-form-label">Tên sản phẩm</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="tensanpham" name="tensanpham" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="masp" class="col-sm-3 col-form-label">Mã sản phẩm</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="masp" name="masp" value="<?php echo $masp; ?>" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="giasp" class="form-label">Giá sản phẩm</label>
                        <input type="number" class="form-control" id="giasp" name="giasp" min="0" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="soluong" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="soluong" name="soluong" min="0" required>
                    </div>
                </div>

                <!-- Hình ảnh -->
                <div class="mb-3 row">
                    <label for="hinhanh" class="col-sm-3 col-form-label">Hình ảnh</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" id="hinhanh" name="hinhanh" accept="image/*" required>
                        <div id="preview" class="mt-2"></div>
                    </div>
                </div>

                <!-- Mô tả sản phẩm -->
                <div class="mb-3">
                    <label for="tomtat" class="form-label">Tóm tắt sản phẩm</label>
                    <textarea class="form-control" id="tomtat" name="tomtat" rows="3"></textarea>
                </div>

                <!-- Phân loại -->
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="danhmuc" class="form-label">Danh mục sản phẩm</label>
                        <select class="form-select" id="danhmuc" name="danhmuc" required>
                            <option value="">Chọn danh mục</option>
                            <?php  
                                $sql_danhmuc = "SELECT * FROM product_catelog ORDER BY id DESC";  
                                $result = $mysqli->query($sql_danhmuc);  
                                if ($result) {  
                                    while ($row_danhmuc = $result->fetch_assoc()) {  
                                        echo '<option value="' . htmlspecialchars($row_danhmuc['id']) . '">' . 
                                            htmlspecialchars($row_danhmuc['ten']) . '</option>';
                                    }  
                                    $result->free();  
                                }  
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="tinhtrang" class="form-label">Trạng thái</label>
                        <select class="form-select" id="tinhtrang" name="tinhtrang" required>
                            <option value="">Chọn trạng thái</option>
                            <option value="1">Kích hoạt</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" name="themsanpham" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm sản phẩm
                </button>
            </div>
            </form>
        </div>
    </div>
</div>