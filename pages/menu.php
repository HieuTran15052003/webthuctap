<?php
    include('processing/handle_menu.php');
?> 
<!-- NAVIGATION -->
<nav id="navigation">
			<!-- container -->
			<div class="container">
                
                <button class="menu-toggle">☰</button>

				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
                        <?php
                            $current_page = isset($_GET['management']) ? $_GET['management'] : 'home';
                        ?>
                        <li class="<?php echo ($current_page == 'home') ? 'active' : ''; ?>">
                            <a href="index.php">Trang chủ</a>
                        </li>
                        <?php  
                            if(isset($_SESSION['log_in']) && $_SESSION['role'] == 'user') {
                        ?>
                            <li class="<?php echo ($current_page == 'order_history') ? 'active' : ''; ?>">
                                <a href="index.php?management=order_history">Lịch sử đơn hàng</a>
                            </li>
                            <li>
                                <a href="index.php?log_out=1">Đăng xuất</a>
                            </li>
                            <li class="<?php echo ($current_page == 'change_password') ? 'active' : ''; ?>">
                                <a href="index.php?management=change_password">Đổi mật khẩu</a>
                            </li>
                        <?php  
                            } else {
                        ?>
                            <li class="<?php echo ($current_page == 'register') ? 'active' : ''; ?>">
                                <a href="index.php?management=register">Đăng ký tài khoản</a>
                            </li>
                        <?php  
                            }
                        ?>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
<!-- /NAVIGATION -->