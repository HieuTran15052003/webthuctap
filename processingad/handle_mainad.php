<?php
// Xác định biến $pow và $query với giá trị mặc định  
        $pow = '';  
        $query = '';  
        
        // Kiểm tra xem có 'action' và 'query' trong $_GET hay không  
        if (isset($_GET['action'])) {  
            $pow = $_GET['action'];  
            // Kiểm tra nếu 'query' tồn tại trong $_GET  
            if (isset($_GET['query'])) {  
                $query = $_GET['query']; // Lấy giá trị của 'query'  
            }  
        }  
        
        // Kiểm tra các hành động và chỉ định các file để include  
        if ($pow == 'manage_product_catalog' && $query == 'more') { 
            include('modules/manage_product_catalog/list.php');   
            include('modules/manage_product_catalog/more.php');  
        }elseif ($pow == 'manage_product_catalog' && $query == 'fix') {  
            include('modules/manage_product_catalog/fix.php');  
        }elseif ($pow == 'product_management' && $query == 'more') {  
            include('modules/product_management/list.php'); 
        }elseif ($pow == 'product_management' && $query == 'fix') {  
            include('modules/product_management/fix.php');  
        }elseif ($pow == 'order_management' && $query == 'list') {  
            include('modules/order_management/list.php');  
        }elseif ($pow == 'order' && $query == 'view_order') {  
            include('modules/order_management/view_order.php');  
        }else {  
            include('modules/manage_product_catalog/list.php');  
        }  
?>