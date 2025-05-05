<?php
    if(isset($_GET['management'])) {
        $pow = $_GET['management'];
    } else {
        $pow= '';
    }
    if($pow == 'product_catelog') {
        include('processing/product_catelog.php');
    }elseif($pow == 'shopping_cart') {
        include('processing/shopping_cart.php');
    }elseif($pow == 'manage_article_categories') {
        include('processing/manage_article_categories.php');
    }elseif($pow == 'article') {
        include('processing/article.php');
    }elseif($pow == 'news') {
        include('processing/news.php');
    }elseif($pow == 'comment') {
        include('pages/main/comment.php');
    }elseif($pow == 'product') {
        include('processing/product.php');
    }elseif($pow == 'register') {
        include('pages/register.php');
    }elseif($pow == 'log_in') {
        include('pages/login.php');
    }elseif($pow == 'transport') {
        include('processing/transport.php');
    }elseif($pow == 'payment_information') {
        include('processing/payment_information.php');
    }elseif($pow == 'pay') {
        include('processing/handle_pay.php');
    }elseif($pow == 'search') {
        include('processing/search.php');
    }elseif($pow == 'thanks') {
        include('processing/thanks.php');
    }elseif($pow == 'change_password') {
        include('pages/main/change_password.php');
    }elseif($pow == 'order_history') {
        include('processing/order_history.php');
    }elseif($pow == 'view_order') {
        include('processing/handle_view_order.php');
    }elseif($pow == 'view_order_and_rate') {
        include('processing/handle_view_order_and_rate.php');
    }elseif($pow == 'verify') {
        include('processing/verify.php');
    }else {
        include('processing/index_main.php');
    }
?> 