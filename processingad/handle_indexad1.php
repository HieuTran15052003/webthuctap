<?php 
session_start();
if (!isset($_SESSION['log_in']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php?management=log_in"); 
    exit();
}
?>