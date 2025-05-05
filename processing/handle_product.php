<?php
// Kiểm tra xem id có tồn tại trong URL hay không
if (isset($_GET['id_catelog'])) {
    $id = intval($_GET['id_catelog']);

    $stmt = $mysqli->prepare("SELECT * FROM product, product_catelog 
                              WHERE product.id = product_catelog.id 
                              AND product.id = ? 
                              ORDER BY product.id_sanpham LIMIT 4");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $query_pro = $stmt->get_result();
} else {
    $query_pro = null;
}

// Kiểm tra xem có sản phẩm nào không
if (mysqli_num_rows($query_pro) > 0) {
    while ($row = mysqli_fetch_array($query_pro)) {  
        $id_sanpham = $row['id_sanpham']; // Lấy id_sanpham cho sản phẩm hiện tại
?> 
    <div class="col-md-3 col-xs-6">
        <div class="product">
            <a href="index.php?management=product&id=<?php echo $row['id_sanpham'] ?>&id_catelog=<?php echo $row['id'] ?>">
                <div class="product-img">
                    <img src="admin/modules/product_management/uploads/<?php echo $row['hinhanh'] ?>">
                </div>
                <div class="product-body">
                    <p class="product-category"><?php echo $row['ten'] ?></p>
                    <h3 class="product-name"><a href="#"><?php echo $row['tensanpham'] ?></a></h3>
                    <h4 class="product-price"><?php echo number_format($row['giasp'], 0, ',', '.') . 'vnđ' ?></h4>
                </div>
            </a>
        </div>
    </div>
<?php  
    }
} else {
    echo "<p>No products found.</p>";
}
?>
