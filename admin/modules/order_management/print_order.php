<?php
require 'H:/xamppp/htdocs/webthuctap/vendor/autoload.php';
use Mpdf\Mpdf;

include('../../config/config.php');


$code = $_GET['code'];

// Tạo PDF với MPDF
try {
    $mpdf = new Mpdf([
        'default_font' => 'dejavusans',
    ]);
} catch (\Mpdf\MpdfException $e) {
    echo "Lỗi khi tạo đối tượng Mpdf: " . $e->getMessage();
}

$mpdf->AddPage("0");

try {
    // Sử dụng truy vấn tham số hóa để bảo vệ SQL Injection
    $sql_lietke_dh = "SELECT cart_details.id_cart_details, cart_details.code_cart, 
                             product.tensanpham, cart_details.soluong_buy, product.giasp 
                      FROM cart_details
                      INNER JOIN product ON cart_details.id_sanpham = product.id_sanpham
                      WHERE cart_details.code_cart = :code_cart
                      ORDER BY cart_details.id_cart_details DESC";

    $stmt = $conn->prepare($sql_lietke_dh);
    $stmt->bindParam(':code_cart', $code, PDO::PARAM_STR);
    $stmt->execute();
    $query_lietke_dh = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$query_lietke_dh) {
        die("Không tìm thấy dữ liệu cho mã đơn hàng này.");
    }
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}

// Tạo HTML để render
$html = '<h3>Đơn hàng của bạn gồm có:</h3>';
$html .= '<table border="1" cellpadding="5">
    <tr style="background-color: #C1E5FC;">
        <th>ID</th>
        <th>Mã đơn hàng</th>
        <th>Tên sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá</th>
        <th>Tổng tiền</th>
    </tr>';

$i = 0;
$thanhtien = 0;
foreach ($query_lietke_dh as $row) {
    $i++;
    $tongtien = $row['soluong_buy'] * $row['giasp'];
    $thanhtien+=$tongtien;
    $html .= '<tr>
        <td>' . $i . '</td>
        <td>' . htmlspecialchars($row['code_cart']) . '</td>
        <td>' . htmlspecialchars($row['tensanpham']) . '</td>
        <td>' . htmlspecialchars($row['soluong_buy']) . '</td>
        <td>' . number_format($row['giasp'], 0, ',', '.') . ' VNĐ</td>
        <td>' . number_format($tongtien, 0, ',', '.') . ' VNĐ</td>
    </tr>';
}

$html .= '</table>';
$html .= '<p>Tổng tiền cần phải thanh toán là: ' . number_format($thanhtien, 0, ',', '.') . ' VNĐ</p>';
$html .= '<p>Cảm ơn bạn đã đặt hàng tại website của chúng tôi.</p>';

// Render HTML
$mpdf->WriteHTML($html);

// Xuất PDF
$mpdf->Output();
?>
