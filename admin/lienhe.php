<?php
session_start();
@include 'config.php';
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
        <h2 style="text-align: center;padding: 10px; font-weight: bold;">Phản hồi từ khách hàng</h2>
        <section class="display-product-table" >

            <table class="table table-striped">

                <thead >
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Nội dung </th>
                    <th style="width:100px">Trạng thái</th>
                </thead>

                <tbody>
                    <?php

                    $select_products = mysqli_query($conn, "SELECT * FROM phanhoi");
                    if (mysqli_num_rows($select_products) > 0) {
                        while ($row = mysqli_fetch_assoc($select_products)) {
                    ?>

                            <tr>
                                
                                <td style="width:100px"><?php echo $row['ten']; ?></td>
                                <td style=""><?php echo $row['email']; ?></td>
                                <td style=""><?php echo $row['sdt']; ?></td>
                                <td style=""><?php echo $row['noidung']; ?></td>
                                <td>
								<a href="" class="option-btn" style="padding: 0px;background-color: cornsilk;"> <i class="fas fa-edit"></i> Liên hệ </a>
							    </td>
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