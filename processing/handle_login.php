<?php
require_once('admin/config/config.php');
if (isset($_GET['verified'])) {
    $verificationStatus = $_GET['verified'];
    
    if ($verificationStatus === 'success') {
        echo '<div class="message-success">Xác thực OTP thành công! Bạn có thể đăng nhập ngay bây giờ.</div>';
    }
}
if (isset($_POST['log_in'])) {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Mảng lưu lỗi
    $errors = [];

    // Kiểm tra tên đăng nhập có nhập không
    if (empty($username)) {
        $errors[] = "Vui lòng nhập tên đăng nhập.";
    }

    // Kiểm tra mật khẩu có nhập không
    if (empty($password)) {
        $errors[] = "Vui lòng nhập mật khẩu.";
    }

    // Nếu không có lỗi đầu vào, kiểm tra thông tin trong database
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $errors[] = "Tên đăng nhập không tồn tại.";
        } else {
            // Kiểm tra email đã xác nhận chưa
            if ($user['email_verified'] != 1) {
                $errors[] = "Email chưa được xác nhận.";
            }
            // Kiểm tra mật khẩu
            if (!password_verify($password, $user['password'])) {
                $errors[] = "Mật khẩu không đúng.";
            }
        }
    }

    // Nếu có lỗi, lưu lỗi vào session và chuyển hướng lại trang đăng nhập
    if (!empty($errors)) {
        session_start();
        $_SESSION['register_errors'] = $errors;
        header("Location: index.php?management=log_in");
        exit();
    }

    // Nếu đăng nhập thành công
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];  
    $_SESSION['log_in'] = $user['username'];
    $_SESSION['email'] = $user['email'];  
    $_SESSION['id_khachhang'] = $user['id'];
    $_SESSION['role'] =  $user['role'];

    // Điều hướng theo quyền
    if ($user['role'] == 'user') {
        header('Location:index.php?management=shopping_cart');
    } else if ($user['role'] == 'admin') {
        header('Location:http://localhost/webthuctap/admin/indexad.php');
    } else if ($user['role'] == 'manager') {
        // header('Location:http://localhost/web1/manager/index.php');
    } else {
        $errors[] = "Tài khoản không hợp lệ.";
        session_unset();
        session_destroy();
    }
    exit();
}
?>
<?php
if (isset($_SESSION['register_errors'])) {
    echo "<ul class='error-list'>";
    foreach ($_SESSION['register_errors'] as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    unset($_SESSION['register_errors']);
}
?>
