<?php if(isset($_GET['log_out']) && $_GET['log_out'] == 1 ) {
        unset($_SESSION['log_in']);
        header("Location:../index.php?management=log_in");  
    } ?>
    <li>
        <a href="indexad.php?log_out=1">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất: 
            <?php if(isset($_SESSION['log_in'])) echo $_SESSION['log_in']; ?>
        </a>
    </li>