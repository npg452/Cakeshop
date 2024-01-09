<?php
session_start();
@include 'config.php';
if (isset($_GET['xoabl'])) {
	$delete_id = $_GET['xoabl'];
	$delete_query = mysqli_query($conn, "DELETE FROM binhluan WHERE idbl = $delete_id") or die('Query failed');
	if ($delete_query) {
		header('location: binhluan.php');
		$message[] = 'Bình luận đã được xóa ';
	} else {
		header('location: binhluan.php');
		$message[] = 'Xóa bình luận không thành công';
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
    <style>
        .card {
            margin: 15px;
        }
    </style>
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
        <h2 style="text-align: center;padding: 10px; font-weight: bold;">Bình luận từ khách hàng</h2>
        <section class="display-product-table">

            <table class="table table-striped">

                <thead>
                    <th>Họ tên</th>
                    <th>Nội dung </th>
                    <th>Thời gian</th>
                    <th>Sản phẩm</th>
                    <th>Trạng thái</th>
                </thead>

                <tbody>
                    <?php
                    $select_products = mysqli_query($conn, "SELECT binhluan.*, users.hoten, sanpham.tensanpham
                    FROM binhluan
                    INNER JOIN users ON binhluan.iduser = users.iduser
                    INNER JOIN sanpham ON binhluan.idsp = sanpham.id
                    ORDER BY binhluan.thoigian DESC;
                    ");


                    if (mysqli_num_rows($select_products) > 0) {
                        while ($row = mysqli_fetch_assoc($select_products)) {
                    ?>

                            <tr>

                                <td style="width:100px"><?php echo $row['hoten']; ?></td>
                                <td style=""><?php echo $row['noidung']; ?></td>
                                <td style=""><?php echo $row['thoigian']; ?></td>
                                <td><?php echo $row['tensanpham']; ?></td>
                                <td><a href="binhluan.php?xoabl=<?php echo $row['idbl']; ?>" onclick="return confirm('Bạn muốn xóa bình luận này');"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg></a></td>
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