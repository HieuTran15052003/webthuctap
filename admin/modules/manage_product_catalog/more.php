<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Thêm danh mục sản phẩm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="modules/manage_product_catalog/handle.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tendanhmuc" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="tendanhmuc" name="tendanhmuc"  required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button name="themdanhmuc" type="submit" class="btn btn-primary">Thêm danh mục</button>
                </div>
            </form>
        </div>
    </div>
</div>