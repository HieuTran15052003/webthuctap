<div class="row">
    <div class="register">
        <h2>Đổi mật khẩu</h2>
        <?php
            include('processing/handle_change_password.php')
        ?>
        <form method="post" action="">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email đăng nhập" required>
            </div>
            <div class="form-group">
                <input type="text" name="password_old" placeholder="Mật khẩu cũ" required>
            </div>
            <div class="form-group">
                <input type="text" name="password_new" placeholder="Mật khẩu mới" required>
            </div>
            <div class="form-group">
                <button type="submit" name="change_password">Đổi mật khẩu</button>
            </div> 
        </form>
    </div>
</div>