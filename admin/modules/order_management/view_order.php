<p>Xem đơn hàng</p>
<?php  
// Giả sử bạn đã bao gồm tệp config.php với kết nối PDO ở đó  
include('config/config.php');  
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
<div class="table-responsive">
    <table class="table table-bordered" style="border-collapse:collapse;width:100%;">  
        <thead class="thead-light">
            <tr>  
                <th>ID</th>  
                <th>Mã đơn hàng</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>       
                <th>Thành tiền</th>  
            </tr>  
        </thead>
        <tbody>
            <?php  
            $i = 0;
            $tongtien = 0;  
            foreach ($query_lietke_dh as $row) {  
                $i++;
                $thanhtien = $row['giasp'] * $row['soluong_buy'];
                $tongtien += $thanhtien;
            ?>  
                <tr>  
                    <td><?php echo $i; ?></td>  
                    <td><?php echo htmlspecialchars($row['code_cart']); ?></td>
                    <td><?php echo htmlspecialchars($row['tensanpham']); ?></td> 
                    <td><?php echo htmlspecialchars($row['soluong_buy']); ?></td>
                    <td><?php echo number_format($row['giasp'], 0, ',', '.') . ' vnđ';?></td>
                    <td><?php echo number_format($thanhtien, 0, ',', '.') . ' vnđ'; ?></td>
                </tr>
            <?php  
            }  
            ?> 
            <tr>
                <td colspan="6" class="text-right">
                    <p><strong>Tổng tiền: <?php echo number_format($tongtien, 0, ',', '.') . ' vnđ'; ?></strong></p>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <p><strong>Cập nhật tình trạng đơn hàng</strong></p>
                    <form method="POST" action="modules/order_management/handle.php">
                        <input type="hidden" value="<?php echo $_GET["code"] ?>" name="code_cart">
                        <div class="form-group">
                            <select class="form-control" name="tinhtrangdonhang">
                                <option value="1">Đơn hàng mới</option>
                                <option value="2">Đang vận chuyển</option>
                                <option value="3">Đã giao hàng | hoàn thành</option>
                            </select>
                        </div>
                        <button type="submit" name="update_cart" class="btn btn-primary">Cập nhật đơn hàng</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>