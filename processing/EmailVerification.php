<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include(__DIR__ . '/../vendor/autoload.php');

class EmailVerification {
    private $db;
    private $mailer;

    public function __construct($db) {
        $this->db = $db;
        $this->mailer = new PHPMailer(true);

        // Cấu hình SMTP
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'abcdfbbb@gmail.com';
        $this->mailer->Password = 'nwhf fkcv hcnx slby';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
        $this->mailer->CharSet = 'UTF-8';
    }

    // Hàm tạo mã OTP ngẫu nhiên
    private function generateOTP() {
        return rand(100000, 999999); // Mã OTP 6 chữ số
    }

    // Tạo và cập nhật OTP mới cho người dùng
    public function createOTP($userId) {
        date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ Việt Nam

        $otp = $this->generateOTP();
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $stmt = $this->db->prepare("UPDATE users SET verification_code = ?, token_expiry = ?, email_verified = 0 WHERE id = ?");
        if ($stmt->execute([$otp, $expiry, $userId])) {
            return $otp;
        } else {
            return false;
        }
    }

    // Gửi email xác thực với OTP
    public function sendVerificationEmail($userEmail, $otp) {
        try {
            $this->mailer->setFrom('abcdfbbb@gmail.com', 'SHOP PHỤ KIỆN ĐIỆN THOẠI');
            $this->mailer->addAddress($userEmail);

            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Xác thực tài khoản của bạn';
            $this->mailer->Body = "<h2>Xác thực tài khoản</h2>
                <p>Mã OTP của bạn là: <strong>{$otp}</strong></p>
                <p>Vui lòng nhập mã này vào trang xác thực. Mã sẽ hết hạn sau 10 phút.</p>";

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
    }

    // Gửi lại mã OTP mới khi người dùng yêu cầu
    public function resendOTP($userId) {
        try {
            // Lấy thông tin người dùng
            $stmt = $this->db->prepare("SELECT email FROM users WHERE id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                return "Không tìm thấy người dùng.";
            }
            
            $user = $result->fetch_assoc();
            $email = $user['email'];
            
            // Tạo OTP mới
            $otp = $this->generateOTP();
            $expiryTime = date('Y-m-d H:i:s', strtotime('+10 minutes')); // OTP hết hạn sau 10 phút
            
            // Cập nhật OTP mới trong cơ sở dữ liệu
            $stmt = $this->db->prepare("UPDATE users SET verification_code = ?, token_expiry = ?, email_verified = 0 WHERE id = ?");
            $stmt->bind_param("ssi", $otp, $expiryTime, $userId);
            
            if (!$stmt->execute()) {
                return "Lỗi khi cập nhật mã xác thực.";
            }
            
            // Gửi OTP qua email
            if ($this->sendVerificationEmail($email, $otp)) {
                return true;
            } else {
                return "Lỗi khi gửi email.";
            }
        } catch (Exception $e) {
            return "Đã xảy ra lỗi: " . $e->getMessage();
        }
    }

    // Xác thực OTP khi người dùng nhập
    public function verifyOTP($userId, $otp) {
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->db->prepare("SELECT id FROM users WHERE id = ? AND verification_code = ? AND token_expiry > NOW() AND email_verified = 0");
        $stmt->bind_param("is", $userId, $otp); // "i" = integer, "s" = string
        $stmt->execute();
        
        // Lấy kết quả
        $result = $stmt->get_result();
        $user = $result->fetch_assoc(); // Lấy dữ liệu dạng array
        
        // Đóng statement
        $stmt->close();
    
        if ($user) {
            // Nếu tìm thấy user, cập nhật trạng thái email_verified
            $updateStmt = $this->db->prepare("UPDATE users SET email_verified = 1, verification_code = NULL, token_expiry = NULL WHERE id = ?");
            $updateStmt->bind_param("i", $userId);
            $updateStmt->execute();
            $updateStmt->close(); // Đóng statement sau khi dùng
    
            return true;
        }
    
        return false; // OTP sai hoặc đã hết hạn
    }
}
