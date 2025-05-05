<div class="row">
    <div class="register">
        <h2>Đăng ký tài khoản</h2>
        <?php
            include('processing/handle_register.php');
        ?>
        <form action="" method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Tên đăng nhập" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="text" name="sdt" placeholder="Số điện thoại" required minlength="10" maxlength="11" required> 
            </div>
            <div class="form-group">
                <input type="text" name="diachi" placeholder="Địa chỉ" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <div class="form-group">
                <button type="submit" name="register">Đăng ký</button>
            </div>
        </form>
        <p>Đã có tài khoản? <a href="index.php?management=log_in">Đăng nhập</a></p>
    </div>
</div>