<?php
session_start();
@include 'config.php';
if (isset($_GET['xoatk'])) {
	$delete_id = $_GET['xoatk'];
	$delete_query = mysqli_query($conn, "DELETE FROM users WHERE iduser = $delete_id") or die('Query failed');
	if ($delete_query) {
		header('location: quanlytaikhoan.php');
		$message[] = 'Tài khoản đã được xóa ';
	} else {
		header('location: quanlytaikhoan.php');
		$message[] = 'Xóa tài khoản không thành công';
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="logo.png" rel="icon" type="image&#x2F;vnd.microsoft.icon">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <link rel="stylesheet" href="../css/card.css" type="text/css">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_qlsp.css">
    <title>Quản lý bán bánh</title>
</head>

<body>

<?php include('sidebar.php') ?>


    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>
            

           
            <a href="#" class="profile">
                <img src="logo.png">
            </a>
        </nav>
        <h2 style="text-align: center;padding: 10px; font-weight: bold;">Tài khoản</h2>
        <section class="display-product-table">

            <table class="table table-striped">

                <thead style="text-align: center;">
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Mật khẩu </th>
                    <th>Vai trò</th>
                    <th>Xóa</th>
                </thead>

                <tbody>
                    <?php

                    $select_products = mysqli_query($conn, "SELECT * FROM users");
                    if (mysqli_num_rows($select_products) > 0) {
                        while ($row = mysqli_fetch_assoc($select_products)) {
                    ?>

                            <tr style="text-align: center;">

                                <td style="width:100px"><?php echo $row['hoten']; ?></td>
                                <td style=""><?php echo $row['email']; ?></td>
                                <td style=""><?php echo $row['sdt']; ?></td>
                                <td style=""><?php echo $row['matkhau']; ?></td>
                                <td style=""><?php echo $row['role']; ?></td>
                                <td><a href="quanlytaikhoan.php?xoatk=<?php echo $row['iduser']; ?>" onclick="return confirm('Bạn muốn xóa tài khoản này');"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg></a></td>
                            </tr>

                    <?php
                        };
                    }
                    ?>
                </tbody>
            </table>

        </section>

</body>

</html>