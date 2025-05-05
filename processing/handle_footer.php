<?php
    $sql_danhmuc = "SELECT * FROM product_catelog ORDER BY id DESC";  
    $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);
    while ($row = mysqli_fetch_array($query_danhmuc)) {  
?>
<li><a href="index.php?management=product_catelog&id=<?php echo $row['id'] ?>"><?php echo $row['ten'] ?></a></li>
<?php  
    }
?>