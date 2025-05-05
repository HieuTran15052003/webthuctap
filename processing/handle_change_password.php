<?php
require_once('admin/config/config.php');
if (isset($_POST['change_password'])) {

    // Lấy dữ liệu và làm sạch
    $email = trim($_POST['email']);
    $password_old = trim($_POST['password_old']);
    $password_new = trim($_POST['password_new']);
    
    $errors = []; // Mảng chứa lỗi

    // Kiểm tra email hợp lệ trước khi thao tác với CSDL
    if (empty($email)) {
        $errors[] = "Vui lòng nhập email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Địa chỉ email không hợp lệ.";
    }

    // Kiểm tra mật khẩu cũ và mới có nhập không
    if (empty($password_old)) {
        $errors[] = "Vui lòng nhập mật khẩu cũ.";
    }
    if (empty($password_new)) {
        $errors[] = "Vui lòng nhập mật khẩu mới.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{8,}$/', $password_new)) {
        $errors[] = "Mật khẩu mới phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.";
    }

    // Kiểm tra thông tin người dùng trong database
    $email = mysqli_real_escape_string($mysqli, $email);
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        $errors[] = "Email không đúng.";
    } else { // Chỉ kiểm tra mật khẩu nếu email tồn tại
        if (!password_verify($password_old, $user['password'])) {
            $errors[] = "Mật khẩu cũ không đúng.";
        }
    }
    // Nếu có lỗi, lưu vào session
    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        header("Location: index.php?management=change_password");
        exit();
    }
    // Mã hóa và cập nhật mật khẩu mới
    $password_hash = password_hash($password_new, PASSWORD_DEFAULT);
    $sql_update = "UPDATE users SET password = ? WHERE email = ?";
    $stmt_update = $mysqli->prepare($sql_update);
    $stmt_update->bind_param("ss", $password_hash, $email);

    if ($stmt_update->execute()) {
        $_SESSION['message_change_pw'] = "Mật khẩu đã được thay đổi thành công!";
        header("Location: index.php?management=change_password&success=1");
        exit();
    } else {
        $_SESSION['register_errors'] = ["Có lỗi xảy ra khi cập nhật mật khẩu. Vui lòng thử lại."];
        header("Location: index.php?management=change_password");
        exit(); // Thêm exit() để đảm bảo không tiếp tục thực thi
    }
}

?>
<?php
if (isset($_SESSION['message_change_pw'])) {
    echo "<div class='message-success'>" . htmlspecialchars($_SESSION['message_change_pw']) . "</div>";
    unset($_SESSION['message_change_pw']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='message-error'>" . htmlspecialchars($_SESSION['error']) . "</div>";
    unset($_SESSION['error']);
}

if (isset($_SESSION['register_errors'])) {
    echo "<ul class='error-list'>";
    foreach ($_SESSION['register_errors'] as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    unset($_SESSION['register_errors']);
}
?>