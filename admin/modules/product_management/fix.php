<?php  
    $sql_sua_sp = "SELECT * FROM product WHERE id_sanpham = '" . $_GET['idsanpham'] . "' LIMIT 1";
    $query_sua_sp = mysqli_query($mysqli,$sql_sua_sp);  
?>  
<p>Sửa sản phẩm</p> 
<?php
while($row = mysqli_fetch_array($query_sua_sp)) {
?> 
    <div class="table-responsive"> <!-- Bao bọc bảng bằng class table-responsive -->
    <form method="POST" action="modules/product_management/handle.php?idsanpham=<?php echo $row['id_sanpham'] ?>" enctype="multipart/form-data">             
        <table class="table table-bordered" style="border-collapse:collapse;">   
            <tr>  
                <td>Tên sản phẩm</td>  
                <td><input type="text" name="tensanpham" value="<?php echo $row['tensanpham'] ?>" required></td>  
            </tr>  
            <tr>  
                <td>Mã sản phẩm</td>  
                <td><input type="text" name="masp" value="<?php echo $row['masp'] ?>" required></td>  
            </tr>  
            <tr>  
                <td>Giá sản phẩm</td>  
                <td><input type="number" name="giasp" value="<?php echo $row['giasp'] ?>" required></td>  
            </tr>  
            <tr>  
                <td>Số lượng</td>  
                <td><input type="number" name="soluong" value="<?php echo $row['soluong'] ?>" required></td>  
            </tr>  
            <tr>  
                <td>Hình ảnh</td>  
                <td>  
                    <input type="file" name="hinhanh" id="hinhanh">  
                    <img src="modules/product_management/uploads/<?php echo $row['hinhanh']?>" width="150px"> 
                    <p>Preview Image Before Uploading</p>
                    <div id="preview"></div>
                </td>  
            </tr>  
            <tr>  
                <td>Tóm tắt</td>  
                <td><textarea rows="10" name="tomtat" id="tomtat" style="resize:none"><?php echo $row['tomtat']?></textarea></td>  
            </tr>   
            <tr>  
                <td>Danh mục sản phẩm</td>  
                <td>  
                    <select name="danhmuc" required>  
                        <?php  
                            $sql_danhmuc = "SELECT * FROM product_catelog ORDER BY id DESC";  
                            $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
                            while($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
                                if($row_danhmuc['id'] == $row['id']) {
                        ?>   
                            <option selected value="<?php echo $row_danhmuc['id']?>"><?php echo $row_danhmuc['ten'] ?></option>  
                        <?php  
                            } else {
                        ?>
                        <option value="<?php echo $row_danhmuc['id']?>"><?php echo $row_danhmuc['ten'] ?></option>
                        <?php  
                            }
                        }    
                        ?>    
                    </select>  
                </td>  
            </tr>
            <tr>  
                <td>Tình trạng</td>  
                <td>  
                    <select name="tinhtrang" required>
                        <?php 
                        if ($row['tinhtrang'] == 1) {
                        ?> 
                        <option value="1" selected>Kích hoạt</option>  
                        <option value="0">Ẩn</option>
                        <?php 
                        } else {
                        ?>
                        <option value="1">Kích hoạt</option>  
                        <option value="0" selected>Ẩn</option> 
                        <?php 
                        }
                        ?>   
                    </select>  
                </td>  
            </tr>
            <tr>  
                <td colspan="2"><input type="submit" name="suasanpham" value="Cập nhật sản phẩm"></td>  
            </tr>  
        </table>
    </form>  
</div>
<?php 
}
?> 

