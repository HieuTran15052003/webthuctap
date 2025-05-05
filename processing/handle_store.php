<?php  
    // Truy vấn danh sách danh mục, kèm theo số lượng sản phẩm
    $sql_danhmuc = "
        SELECT pc.id, pc.ten, COUNT(p.id) AS product_count 
        FROM product_catelog pc
        LEFT JOIN product p ON pc.id = p.id 
        GROUP BY pc.id 
        ORDER BY pc.id DESC
    ";  
    $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
    while ($row = mysqli_fetch_array($query_danhmuc)) {  
?> 
<div class="checkbox-filter">
    <div class="input-checkbox">
        <input type="checkbox" id="category-<?php echo $row['id']; ?>">
        <label for="category-<?php echo $row['id']; ?>">
            <span></span>
            <a href="index.php?management=product_catelog&id=<?php echo $row['id'] ?>">
                <?php echo $row['ten']; ?>
            </a>
            <small>(<?php echo $row['product_count']; ?>)</small>
        </label>
    </div>
</div>
<?php  
    }
?>