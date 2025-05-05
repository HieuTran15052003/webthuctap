<form class="form-left" action="index.php?management=search" method="POST">
    <!-- Dropdown danh mục sản phẩm -->
    <select class="input-select" id="categorySelect">
        <option value="0">Danh mục sản phẩm</option>
        <?php  
        $selected_id = isset($_GET['id']) ? $_GET['id'] : 0; // Lấy id từ URL
        while ($row_danhmuc = $result->fetch_assoc()) {  
            $selected = ($row_danhmuc['id'] == $selected_id) ? 'selected' : ''; // So sánh id với giá trị từ URL
        ?>
            <option value="index.php?management=product_catelog&id=<?php echo $row_danhmuc['id']; ?>" <?php echo $selected; ?>>
                <?php echo htmlspecialchars($row_danhmuc['ten'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php  
        }
        ?>
    </select>


    <!-- JavaScript để xử lý sự kiện chọn danh mục -->
    <script>
        document.getElementById('categorySelect').addEventListener('change', function () {
            var url = this.value; // Lấy giá trị URL từ tùy chọn
            if (url !== "0") { // Bỏ qua tùy chọn "Danh mục sản phẩm"
                window.location.href = url; // Chuyển hướng đến URL
            }
        });
    </script>

    <!-- Ô nhập tìm kiếm -->
    <input 
        class="input" 
        placeholder="Tìm kiếm..." 
        name="key_word" 
        aria-label="Search"
        required
    >

    <!-- Nút tìm kiếm -->
    <button class="search-btn" type="submit" name="search">Tìm kiếm</button>
</form>