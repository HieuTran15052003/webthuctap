<script>
    CKEDITOR.replace('noidung');
    CKEDITOR.replace('tomtat');    
    CKEDITOR.replace('thongtinlienhe');

    

    function imagePreview(fileInput) {
        if (fileInput.files && fileInput.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function (event) {
                $('#preview').html('<img src="'+event.target.result+'" width="300" height="auto"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }
    $("#hinhanh").change(function () {
        imagePreview(this);
    });
</script>