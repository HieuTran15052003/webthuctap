<?php
if (isset($_POST['guilienhe'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $note = $_POST['note'];
    $status = 1;
    if (empty($name)) {
        $errors[] = "Tên không được để trống";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Địa chỉ email không hợp lệ";
    }

    if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
        $errors[] = "Số điện thoại không hợp lệ (phải là số và từ 10-11 chữ số)";
    }
    
    if (empty($note)) {
        $errors[] = "Note không được để trống";
    }
}
?>