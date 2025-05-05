<?php  
// Query lấy 3 sản phẩm mỗi lần
$sql_pro = "SELECT * FROM product,product_catelog WHERE product.id=product_catelog.id AND product.soluongban IS NOT NULL ORDER BY product.id_sanpham";  
$query_pro = mysqli_query($mysqli, $sql_pro);

$counter = 0;  // Đếm số sản phẩm
$product_group = 3;  // Mỗi nhóm có 3 sản phẩm

echo '<div>';  // Bắt đầu nhóm sản phẩm đầu tiên

while ($row = mysqli_fetch_array($query_pro)) {  
    if ($counter % $product_group == 0 && $counter != 0) {
        echo '</div><div>'; // Mỗi khi có 3 sản phẩm, đóng nhóm cũ và bắt đầu nhóm mới
    }
    // Hiển thị sản phẩm
    echo '
        <div class="product-widget">
            <div class="product-img">
                <img src="admin/modules/product_management/uploads/'.$row['hinhanh'].'" alt="">
            </div>
            <div class="product-body">
                <p class="product-category">'.$row['ten'].'</p>
                <h3 class="product-name"><a href="index.php?management=product&id='.$row['id_sanpham'].'&id_catelog='.$row['id'].'">'.$row['tensanpham'].'</a></h3>
                <h4 class="product-price">'.number_format($row['giasp'],0,',','.').'vnđ</h4>
            </div>
            </div>';

    $counter++;
}

echo '</div>'; // Đóng nhóm sản phẩm cuối cùng
?>