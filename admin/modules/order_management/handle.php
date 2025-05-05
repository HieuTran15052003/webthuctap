<?php
require '../../../vendor/autoload.php';
include('../../config/config.php');
use Carbon\Carbon;

$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

if (isset($_GET['code'])) {
    $code_cart = $_GET['code'];
    
    // Sử dụng Prepared Statements để tránh SQL Injection
    $stmt = $mysqli->prepare("UPDATE cart SET cart_status=0 WHERE code_cart=?");
    $stmt->bind_param("s", $code_cart); // 's' là kiểu chuỗi
    $stmt->execute();

    // Thống kê doanh thu
    $sql_lietke_dh = "
        SELECT * FROM cart_details, product
        WHERE cart_details.id_sanpham = product.id_sanpham
        AND cart_details.code_cart = '$code_cart'
        ORDER BY cart_details.id_cart_details DESC";
    $query_lietke_dh = mysqli_query($mysqli, $sql_lietke_dh);

    // Thống kê dữ liệu
    $sql_thongke = "SELECT * FROM statistical WHERE ngaydat='$now'";
    $query_thongke = mysqli_query($mysqli, $sql_thongke);

    $soluongmua = 0;
    $doanhthu = 0;

    while ($row = mysqli_fetch_array($query_lietke_dh)) {
        $soluongmua += $row['soluong_buy'];
        $doanhthu += $row['soluong_buy'] * $row['giasp']; // Cộng doanh thu cho từng sản phẩm
    }

    if (mysqli_num_rows($query_thongke) == 0) {
        // Chèn dữ liệu thống kê mới
        $soluongban = $soluongmua;
        $donhang = 1;
        $sql_update_thongke = mysqli_query(
            $mysqli,
            "INSERT INTO statistical(ngaydat, soluongban, doanhthu, donhang) 
            VALUES ('$now', '$soluongban', '$doanhthu', '$donhang')"
        );
    } else {
        // Cập nhật lại dữ liệu thống kê
        while ($row_tk = mysqli_fetch_array($query_thongke)) {
            $soluongban = $row_tk['soluongban'] + $soluongmua;
            $doanhthu = $row_tk['doanhthu'] + $doanhthu; // Cộng doanh thu hiện tại với doanh thu mới
            $donhang = $row_tk['donhang'] + 1;
            $sql_update_thongke = mysqli_query(
                $mysqli,
                "UPDATE statistical SET soluongban='$soluongban', doanhthu='$doanhthu', donhang='$donhang'
                 WHERE ngaydat='$now'"
            );
        }
    }

    // Chuyển hướng sau khi cập nhật
    header('Location: ../../indexad.php?action=order_management&query=list');
} else if(isset($_POST['update_cart'])) {
    $code_cart = $_POST['code_cart'];
    $tinhtrangdonhang= $_POST['tinhtrangdonhang'];
    $sql_update_tinhtrangdonhang   = mysqli_query($mysqli,"UPDATE cart SET cart_status='$tinhtrangdonhang' WHERE code_cart='$code_cart'");
    header('Location: ../../indexad.php?action=order_management&query=list');
}
?>

