<?php  
// Giả sử bạn đã bao gồm tệp config.php với kết nối PDO ở đó  
include('admin/config/config.php'); 

try {  
    $code = $_GET['code'];
    // Câu truy vấn SQL  
    $spl_lietke_dh = "SELECT * FROM cart_details,product 
                      WHERE cart_details.id_sanpham=product.id_sanpham 
                      AND cart_details.code_cart='".$code."'
                      ORDER BY cart_details.id_cart_details DESC";  

    // Chuẩn bị câu truy vấn  
    $stmt = $conn->prepare($spl_lietke_dh);  
    
    // Thực thi câu truy vấn  
    $stmt->execute();  

    // Lấy tất cả kết quả  
    $query_lietke_dh = $stmt->fetchAll(PDO::FETCH_ASSOC);  
} catch (PDOException $e) {  
    echo "Lỗi: " . $e->getMessage(); // Hiển thị lỗi nếu có  
}  
?>  
<div class="cart-container">
<?php
    $i = 0;
    $tongtien = 0;
    foreach ($query_lietke_dh as $cart_item) {
        $thanhtien = $cart_item['soluong_buy'] * $cart_item['giasp'];
        $tongtien += $thanhtien;
        $i++;
?>
    <div class="cart-item">
        <div class="product-info">
            <div class="product-image">
                <a href="index.php?management=product&id=<?php echo $cart_item['id_sanpham'] ?>&id_catelog=<?php echo $cart_item['id'] ?>">
                    <img src="admin/modules/product_management/uploads/<?php echo $cart_item['hinhanh'] ?>" 
                        alt="<?php echo $cart_item['tensanpham'] ?>">
                </a>
            </div>
            <div class="product-details">
            <h3 class="product-name"><a href="index.php?management=product&id=<?php echo $cart_item['id_sanpham'] ?>&id_catelog=<?php echo $cart_item['id'] ?>"><?php echo $cart_item['tensanpham']?></a></h3>
                <div class="mobile-price">
                    <?php echo number_format($cart_item['giasp'], 0, ',', '.') . 'vnđ' ?>
                </div>
            </div>
        </div>
        
        <div class="price-quantity-group">
            <div class="quantity-controls">       
                <span class="quantity"><?php echo $cart_item['soluong_buy'] ?></span>
            </div>
            
            <div class="price-info">
                <div class="unit-price desktop-price">
                    <?php echo number_format($cart_item['giasp'], 0, ',', '.') . 'vnđ' ?>
                </div>
                <div class="total-price">
                    <?php echo number_format($thanhtien, 0, ',', '.') . 'vnđ' ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
    <div class="cart-summary">
        <div class="total-amount">
            <span class="total-label">Tổng tiền thanh toán:</span>
            <span class="total-value"><?php echo number_format($tongtien, 0, ',', '.') . 'vnđ' ?></span>
        </div>
    </div>
</div>