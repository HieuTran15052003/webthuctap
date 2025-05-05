<div class="row">
    <div class="register">
        <h2>Đăng nhập</h2>
        <?php
            include('processing/handle_login.php');
        ?>
        <form action="" method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Tên đăng nhập" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <div class="form-group">
            <button type="submit" name="log_in">Đăng nhập</button>
            </div>
        </form>
        <p>Chưa có tài khoản? <a href="index.php?management=register">Đăng ký</a></p>
    </div>
</div>
