
<?php include 'header.php'; ?>
    <div id="pageSignin" style="text-align: center;">
        <h1>Lấy lại mật khẩu</h1>
        <form method="post" name="UserGetActiveCode" class="f" id="UserGetActiveCode">
            <ul>
                <li><label for="newpassword" class="required"><span>*</span> Nhập địa chỉ email:</label>
                <input name="inputStr" type="text" " id="newpassword" value=""></li>
                <input type="hidden" name="csrf" >
                <li class="btns"><input name="submit" type="submit" id="btnSubmit"  ></li>
            </ul>
        </form>
    </div>
  




</body>

</html>