<?php
session_start();
@include 'config.php';
?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoten = $_POST['hoten'];
    $email = $_POST['email'];
    $matkhau = $_POST['matkhau'];
    $sdt = $_POST['sdt'];
    $role = 'thanhvien';
    $conn = mysqli_connect("localhost", "root", "", "cakeshop");

    $sql = "INSERT INTO users(hoten,email, matkhau, sdt, role) VALUES ('$hoten','$email', '$matkhau','$sdt', '$role')";
    $kq = mysqli_query($conn, $sql);
    if ($kq) {

        echo json_encode(['success' => true, 'message' => 'Đăng ký tài khoản thành công']);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Đăng ký tài khoản không thành công']);
        exit;
    }
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<?php include 'header.php'; ?>
</div>
<div class="bread-crumb text-center bread-crumb_background" style=" background-image: url('https://pos.nvncdn.net/16a837-71503/bn/20220325_5UxI8S76E0NIJxh0znPFxEOw.png');">
    <h3>Đăng ký tài khoản</h3>
    <ul class="breadcrumb&#x20;breadcrumb-arrow">
        <li><a href="index.php">Trang chủ</a></li>
        <li><a class="564206" href="sanpham.php">Đăng ký tài khoản</a></li>
    </ul>
</div>
<div class="container content-web">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div id="signGF" class="text-center">
                <h3>Đăng ký tài khoản</h3>
                <a rel="nofollow" href="#" id="signFacebook"><i class="fa fa-facebook fb"></i><span>Facebook</span></a>
                <a rel="nofollow" href="#" id="signGoogle"><i class="fa fa-google-plus gp"></i><span>Google</span></a>
            </div>
            <form id="registerForm" action="#" method="post">
                <ul>
                    <li><input name="hoten" id="hoten" placeholder="Họ và tên" type="text" class="txtFullName validate[required]" required></li>
                    <li><input name="email" id="email" placeholder="Địa chỉ Email" type="text" class="txtEmail validate[required]" required></li>
                    <li><input name="matkhau" id="matkhau" placeholder="Mật khẩu" type="password" class="pwdPass validate[required]" required></li>
                    <li><input name="sdt" id="sdt" placeholder="Số điện thoại" type="text" class="txtPhone validate[required,custom[phone]] field-input" required></li>
                    <li><input id="btn-register" type="submit" value="Đăng ký"></li>
                </ul>
            </form>
            <p class="text-center" style="font-size: 13px;"> Bạn có tài khoản rồi vui lòng đăng nhập <a href="dangnhap.php" style="text-decoration: underline">tại đây</a></p>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#registerForm").submit(function(event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "dangky.php",
                data: $(this).serialize(),
                success: function(response) {

                    response = JSON.parse(response);
                    alert(response.message);
                    window.location.href = "index.php";

                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }

            });
        });
    });
</script>

</body>

</html>