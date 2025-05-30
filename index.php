<?php
session_start();
ob_start(); // Bật bộ đệm đầu ra
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <base href="http://localhost/webthuctap/">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>SHOP ÁO QUẦN</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>
        <?php
                include('admin/config/config.php');
                include('pages/header.php');  
                include('pages/menu.php');  
                include('pages/main.php');
                include('pages/footer.php');
        ?> 
		<!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="https://www.paypal.com/sdk/js?client-id=AV0a2l0r9zFNhQX5KN-1wDl8j1WIVppYhvJ2ULjrEW6qPxSfSY1Uq_c4YT60imQprgtHtbCCI5h7rnDH&currency=USD"></script>
		<script src="js/main.js"></script>

	</body>
</html>
<?php
ob_end_flush(); // Gửi nội dung bộ đệm đến trình duyệt
?>
