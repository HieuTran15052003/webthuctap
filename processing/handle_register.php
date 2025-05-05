<?php
require_once('admin/config/config.php');
require_once('processing/EmailVerification.php');

// Hàm làm sạch dữ liệu đầu vào
function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) { 
    // Sanitize và lấy dữ liệu từ form
    $username = sanitizeInput($_POST['username']); 
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $sdt = isset($_POST['sdt']) ? sanitizeInput($_POST['sdt']) : '';
    $diachi = isset($_POST['diachi']) ? sanitizeInput($_POST['diachi']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = 'user';

    // Mảng lưu lỗi
    $errors = [];

    // Kiểm tra dữ liệu đầu vào
    if (empty($username)) {
        $errors[] = "Tên đăng nhập không được để trống";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Địa chỉ email không hợp lệ";
    }

    if (!preg_match('/^[0-9]{10,11}$/', $sdt)) {
        $errors[] = "Số điện thoại không hợp lệ (phải là số và từ 10-11 chữ số)";
    }

    if (empty($diachi)) {
        $errors[] = "Địa chỉ không được để trống";
    }

    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{8,}$/', $password)) {
        $errors[] = "Mật khẩu phải chứa ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số, và ký tự đặc biệt.";
    }

    // Kiểm tra username và email đã tồn tại chưa
    if (empty($errors)) {
        $check_stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors[] = "Tên đăng nhập hoặc email đã tồn tại";
        }
        $check_stmt->close();
    }

    // Nếu có lỗi, lưu vào session và chuyển hướng
    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        header("Location: index.php?management=register");
        exit();
    }

    // Nếu không có lỗi, tiến hành đăng ký
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("INSERT INTO users (username, email, phone, diachi, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $email, $sdt, $diachi, $password_hash, $role);
    
    if ($stmt->execute()) {
        $userId = $stmt->insert_id;

        try {
            // Khởi tạo đối tượng xác thực email
            $emailVerification = new EmailVerification($mysqli); 
            $otp = $emailVerification->createOTP($userId);
            
            if ($emailVerification->sendVerificationEmail($email, $otp)) { 
                $_SESSION['pending_user_id'] = $userId;
                $_SESSION['user_email'] = $email;
                header("Location: index.php?management=verify");
                exit();
            } else {  
                $_SESSION['error'] = "Đăng ký thành công nhưng không thể gửi otp xác thực.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Có lỗi xảy ra trong quá trình gửi otp xác thực: " . $e->getMessage();
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Đăng ký không thành công. Vui lòng thử lại.";
        // Chuyển hướng về trang đăng ký để tránh việc form submit lại
        header("Location: index.php?management=register");
        exit();
    }
} 
?>

<!-- Hiển thị thông báo lỗi / thành công -->
<?php

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
