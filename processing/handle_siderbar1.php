<?php  
    $sql_danhmuc = "SELECT * 
                    FROM product_catelog pc 
                    LEFT JOIN product p ON pc.id = p.id
                    WHERE p.soluongban IS NOT NULL
                    ORDER BY pc.id DESC";  
    $query_danhmuc = mysqli_query($mysqli, $sql_danhmuc);

    $printed_categories = []; // Mảng lưu ID đã in

    while ($row = mysqli_fetch_array($query_danhmuc)) {  
        if (!in_array($row['id'], $printed_categories)) { // Nếu chưa xuất hiện, thì in ra
            $printed_categories[] = $row['id']; // Thêm vào danh sách đã in
?> 
            <li>
                <a href="index.php?id=<?php echo $row['id'] ?>&slb=<?php echo $row['soluongban']?>">
                    <?php echo $row['ten'] ?>
                </a>
            </li>
<?php  
        }
    }
?>
