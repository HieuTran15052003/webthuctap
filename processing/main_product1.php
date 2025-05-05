<?php
// Kiểm tra xem id có tồn tại trong URL hay không
if (isset($_GET['id']) && isset($_GET['new'])) {
    // Lấy giá trị id từ URL và xử lý
    $id = intval($_GET['id']); // Chuyển đổi sang số nguyên để tránh SQL Injection

    // Truy vấn chỉ lấy sản phẩm có id_sanpham bằng $id
    $sql_pro = "SELECT * FROM product, product_catelog 
                WHERE product.id = product_catelog.id 
                AND product.id = $id 
                ORDER BY product.id_sanpham";
} else {
    // Nếu không có id trong URL, lấy tất cả sản phẩm
    $sql_pro = "SELECT * FROM product, product_catelog 
                WHERE product.id = product_catelog.id 
                ORDER BY product.id_sanpham";
}

// Thực hiện truy vấn
$query_pro = mysqli_query($mysqli, $sql_pro);

// Kiểm tra xem có sản phẩm nào không
if (mysqli_num_rows($query_pro) > 0) {
    while ($row = mysqli_fetch_array($query_pro)) {  
        $id_sanpham = $row['id_sanpham']; // Lấy id_sanpham cho sản phẩm hiện tại
        ?>
        <div class="product">
            <a href="index.php?management=product&id=<?php echo $row['id_sanpham'] ?>&id_catelog=<?php echo $row['id'] ?>">
                <div class="product-img">
                    <img src="admin/modules/product_management/uploads/<?php echo $row['hinhanh'] ?>">
                    <div class="product-label">
                        <span class="new">NEW</span>
                    </div>
                </div>
                <div class="product-body">
                    <p class="product-category"><?php echo $row['ten'] ?></p>
                    <h3 class="product-name"><?php echo $row['tensanpham'] ?></h3>
                    <h4 class="product-price"><?php echo number_format($row['giasp'], 0, ',', '.') . 'vnđ' ?></h4>
                </div>
            </a>
        </div>
<?php  
    }
} else {
    echo "<p>No products found.</p>";
}
?>
