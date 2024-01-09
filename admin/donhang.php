<?php
session_start();
@include 'config.php';

date_default_timezone_set('Asia/Ho_Chi_Minh');

if (isset($_POST['save_status'])) {
    $iddh = $_POST['iddh'];
    $newStatus = $_POST['suatrangthai'];

    if ($newStatus == 'Đã giao') {
        $currentDate = date('Y-m-d H:i:s');

        $updateDeliveryDateQuery = "UPDATE donhang SET ngaygiaohang = '$currentDate' WHERE iddh = '$iddh'";
        $resultDeliveryDate = mysqli_query($conn, $updateDeliveryDateQuery);

        if (!$resultDeliveryDate) {
            echo 'Error updating delivery date: ' . mysqli_error($conn);
            exit; 
        }
    }

    $updateQuery = "UPDATE donhang SET trangthai = '$newStatus' WHERE iddh = '$iddh'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        echo 'Cập nhật trạng thái thành công';

        header('Location: donhang.php');
        exit; 
    } else {
        echo 'Error updating status: ' . mysqli_error($conn);
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
        .btnk{
            border-radius: 10px;
            margin: 5px;
            margin-top: 20px;
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
        <section style="font-size: 15px; border: none; width: 270px;border-radius: 10px;background-color: #d8d8d0;">
            <?php
            if (isset($_GET['suatrangthai'])) {
                $suatrangthai = $_GET['suatrangthai'];
                $edit_query = mysqli_query($conn, "SELECT * FROM donhang WHERE iddh = $suatrangthai");
                if (mysqli_num_rows($edit_query) > 0) {
                    while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
            ?>
                        <form action="" method="post" style="padding: 10px;">
                            <input type="hidden" name="iddh" value="<?php echo $fetch_edit['iddh']; ?>">
                            <label for="suatrangthai">Chọn trạng thái mới - Đơn hàng <?php echo $suatrangthai ?></label> <br>
                            <select name="suatrangthai" id="suatrangthai" style="border: none;border-radius: 5px; margin-top: 10px; margin-bottom: 10px;">
                                <option value="<?php echo $fetch_edit['trangthai']; ?>" selected><?php echo $fetch_edit['trangthai']; ?></option>
                                <option value="Đã hủy đơn hàng" <?php echo ($fetch_edit['trangthai'] == 'Đã hủy đơn hàng') ? 'selected' : ''; ?>>Đã hủy đơn hàng</option>
                                <option value="Đã xác nhận" <?php echo ($fetch_edit['trangthai'] == 'Đã xác nhận') ? 'selected' : ''; ?>>Đã xác nhận</option>
                                <option value="Đang chuẩn bị đơn hàng" <?php echo ($fetch_edit['trangthai'] == 'Đang chuẩn bị đơn hàng') ? 'selected' : ''; ?>>Đang chuẩn bị đơn hàng</option>
                                <option value="Đang giao hàng" <?php echo ($fetch_edit['trangthai'] == 'Đang giao hàng') ? 'selected' : ''; ?>>Đang giao hàng</option>
                                <option value="Đã giao" <?php echo ($fetch_edit['trangthai'] == 'Đã giao') ? 'selected' : ''; ?>>Đã giao</option>
                            </select>
                            <br>
                            <input type="submit" value="Lưu trạng thái" name="save_status" style="border: none;border-radius: 5px;">
                        </form>
            <?php
                    }
                }
            } ?>
        </section>
        <style>
            .scrollable-td {
                height: 400px;
                overflow-y: auto;
            }
        </style>
        <button class="btnk" onclick="toggleSection('donHangSection')" style="text-align: center;padding: 10px; font-weight: bold;">Tất cả đơn đặt hàng</button>
        <section id="donHangSection" class="display-product-table" >
            <div class="scrollable-td">
                <table class="table table-striped">
                    <thead>
                        <th>Mã đơn</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết đơn hàng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </thead>
                    <tbody>
                        <?php
                        $select_products = mysqli_query($conn, "SELECT * FROM donhang ORDER BY iddh DESC");

                        if (mysqli_num_rows($select_products) > 0) {
                            while ($row = mysqli_fetch_assoc($select_products)) {
                                $iddh = $row['iddh'];
                                $trangthai = $row['trangthai'];
                                $ngaydathang = $row['ngaydathang'];
                        ?>
                                <tr>
                                    <form class="orderForm" method="post" action="">
                                        <td style="text-align: center;"><?php echo $row['iddh']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                        <td><?php echo $row['tongtien']; ?></td>
                                        <td><a href="chitietdonhang.php?iddh=<?php echo $row['iddh']; ?>">Hiển thị chi tiết</a></td>
                                        <td><?php echo $row['trangthai']; ?></td>
                                        <?php
                                        if ($trangthai != 'Đã hủy đơn hàng' && $trangthai != 'Đã giao') {
                                            echo '<input type="hidden" name="iddh" value="' . $iddh . '">';
                                            echo '<td><a href="donhang.php?suatrangthai=' . $row['iddh'] . '"> <i class="fas fa-edit"></i> Sửa trạng thái </a></td>';
                                        } else {
                                            echo '<td></td>';
                                        }
                                        ?>
                                    </form>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        
<!-- ============================================================================================================== -->
<button class="btnk" onclick="toggleSection('dangcho')" style="text-align: center;padding: 10px; font-weight: bold;">Đơn hàng đang chờ xác nhận</button>
        <section id="dangcho" class="display-product-table" style="display: none;"> 
                <table class="table table-striped">
                    <thead>
                        <th>Mã đơn</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết đơn hàng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </thead>
                    <tbody>
                        <?php
                        $select_products = mysqli_query($conn, "SELECT * FROM donhang WHERE trangthai = 'Đang chờ xác nhận' ORDER BY ngaydathang DESC");
                        if (mysqli_num_rows($select_products) > 0) {
                            while ($row = mysqli_fetch_assoc($select_products)) {
                                $iddh = $row['iddh'];
                                $trangthai = $row['trangthai'];
                                $ngaydathang = $row['ngaydathang'];
                        ?>
                                <tr>
                                    <form class="orderForm" method="post" action="">
                                        <td style="text-align: center;"><?php echo $row['iddh']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                        <td><?php echo $row['tongtien']; ?></td>
                                        <td><a href="chitietdonhang.php?iddh=<?php echo $row['iddh']; ?>">Hiển thị chi tiết</a></td>
                                        <td><?php echo $row['trangthai']; ?></td>
                                        <?php
                                        if ($trangthai != 'Đã hủy đơn hàng' && $trangthai != 'Đã giao') {
                                            echo '<input type="hidden" name="iddh" value="' . $iddh . '">';
                                            echo '<td><a href="donhang.php?suatrangthai=' . $row['iddh'] . '"> <i class="fas fa-edit"></i> Sửa trạng thái </a></td>';
                                        } else {
                                            echo '<td></td>';
                                        }
                                        ?>
                                    </form>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
        
        </section>
<!-- ============================================================================================================== -->
<button class="btnk" onclick="toggleSection('daxacnhan')" style="text-align: center;padding: 10px; font-weight: bold;">Đơn hàng đã xác nhận</button>
        <section id="daxacnhan" class="display-product-table" style="display: none;">
            
                <table class="table table-striped">
                    <thead>
                        <th>Mã đơn</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết đơn hàng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </thead>
                    <tbody>
                        <?php
                        $select_products = mysqli_query($conn, "SELECT * FROM donhang WHERE trangthai = 'Đã xác nhận' ORDER BY ngaydathang DESC");

                        if (mysqli_num_rows($select_products) > 0) {
                            while ($row = mysqli_fetch_assoc($select_products)) {
                                $iddh = $row['iddh'];
                                $trangthai = $row['trangthai'];
                                $ngaydathang = $row['ngaydathang'];
                        ?>
                                <tr>
                                    <form class="orderForm" method="post" action="">
                                        <td style="text-align: center;"><?php echo $row['iddh']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                        <td><?php echo $row['tongtien']; ?></td>
                                        <td><a href="chitietdonhang.php?iddh=<?php echo $row['iddh']; ?>">Hiển thị chi tiết</a></td>
                                        <td><?php echo $row['trangthai']; ?></td>
                                        <?php
                                        if ($trangthai != 'Đã hủy đơn hàng' && $trangthai != 'Đã giao') {
                                            echo '<input type="hidden" name="iddh" value="' . $iddh . '">';
                                            echo '<td><a href="donhang.php?suatrangthai=' . $row['iddh'] . '"> <i class="fas fa-edit"></i> Sửa trạng thái </a></td>';
                                        } else {
                                            echo '<td></td>';
                                        }
                                        ?>



                                    </form>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
        
        </section>
<!-- =============================================================================================================== -->
<button class="btnk" onclick="toggleSection('dangchuanbi')" style="text-align: center;padding: 10px; font-weight: bold;">Đơn hàng đang chuẩn bị</button>
        <section id="dangchuanbi" class="display-product-table" style="display: none;">
            
                <table class="table table-striped">
                    <thead>
                        <th>Mã đơn</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết đơn hàng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </thead>
                    <tbody>
                        <?php
                        $select_products = mysqli_query($conn, "SELECT * FROM donhang WHERE trangthai = 'Đang chuẩn bị đơn hàng'");

                        if (mysqli_num_rows($select_products) > 0) {
                            while ($row = mysqli_fetch_assoc($select_products)) {
                                $iddh = $row['iddh'];
                                $trangthai = $row['trangthai'];
                                $ngaydathang = $row['ngaydathang'];
                        ?>
                                <tr>
                                    <form class="orderForm" method="post" action="">
                                        <td style="text-align: center;"><?php echo $row['iddh']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                        <td><?php echo $row['tongtien']; ?></td>
                                        <td><a href="chitietdonhang.php?iddh=<?php echo $row['iddh']; ?>">Hiển thị chi tiết</a></td>
                                        <td><?php echo $row['trangthai']; ?></td>
                                        <?php
                                        if ($trangthai != 'Đã hủy đơn hàng' && $trangthai != 'Đã giao') {
                                            echo '<input type="hidden" name="iddh" value="' . $iddh . '">';
                                            echo '<td><a href="donhang.php?suatrangthai=' . $row['iddh'] . '"> <i class="fas fa-edit"></i> Sửa trạng thái </a></td>';
                                        } else {
                                            echo '<td></td>';
                                        }
                                        ?>



                                    </form>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
        
        </section>
<!-- =================================================================================== -->
<button class="btnk" onclick="toggleSection('danggiaohang')" style="text-align: center;padding: 10px; font-weight: bold;">Đơn hàng đang giao</button>
        <section id="danggiaohang" class="display-product-table" style="display: none;">
            
                <table class="table table-striped">
                    <thead>
                        <th>Mã đơn</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết đơn hàng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </thead>
                    <tbody>
                        <?php
                        $select_products = mysqli_query($conn, "SELECT * FROM donhang WHERE trangthai = 'Đang giao hàng'");

                        if (mysqli_num_rows($select_products) > 0) {
                            while ($row = mysqli_fetch_assoc($select_products)) {
                                $iddh = $row['iddh'];
                                $trangthai = $row['trangthai'];
                                $ngaydathang = $row['ngaydathang'];
                        ?>
                                <tr>
                                    <form class="orderForm" method="post" action="">
                                        <td style="text-align: center;"><?php echo $row['iddh']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                        <td><?php echo $row['tongtien']; ?></td>
                                        <td><a href="chitietdonhang.php?iddh=<?php echo $row['iddh']; ?>">Hiển thị chi tiết</a></td>
                                        <td><?php echo $row['trangthai']; ?></td>
                                        <?php
                                        if ($trangthai != 'Đã hủy đơn hàng' && $trangthai != 'Đã giao') {
                                            echo '<input type="hidden" name="iddh" value="' . $iddh . '">';
                                            echo '<td><a href="donhang.php?suatrangthai=' . $row['iddh'] . '"> <i class="fas fa-edit"></i> Sửa trạng thái </a></td>';
                                        } else {
                                            echo '<td></td>';
                                        }
                                        ?>



                                    </form>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
        
        </section>
<!-- ============================================================================================ -->
<button class="btnk" onclick="toggleSection('donhangdagiao')" style="text-align: center;padding: 10px; font-weight: bold;">Đơn hàng đã giao</button>
        <section id="donhangdagiao" class="display-product-table" style="display: none;">
            <table class="table table-striped">
                <thead>
                    <th>Mã đơn</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Trạng thái</th>
                </thead>
                <tbody>
                    <?php
                    $select_products = mysqli_query($conn, "SELECT * FROM donhang WHERE trangthai = 'Đã giao'");

                    if (mysqli_num_rows($select_products) > 0) {
                        while ($row = mysqli_fetch_assoc($select_products)) {
                            $iddh = $row['iddh'];
                            $ngaydathang = $row['ngaydathang'];
                    ?>
                            <tr>
                                <form action="" method="post">
                                    <td style="text-align: center;"><?php echo $row['iddh']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                    <td><?php echo $row['tongtien']; ?></td>
                                    <td><a href="chitietdonhang.php?iddh=<?php echo $row['iddh']; ?>">Hiển thị chi tiết</a></td>
                                    <td><?php echo $row['trangthai']; ?></td>
                                </form>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
<!-- =========================================================================================== -->
<button class="btnk" onclick="toggleSection('dangchohuy')" style="text-align: center;padding: 10px; font-weight: bold;">Đơn hàng đang chờ xác nhận hủy</button>
        <section id="dangchohuy" class="display-product-table" style="display: none;">
            
                <table class="table table-striped">
                    <thead>
                        <th>Mã đơn</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Chi tiết đơn hàng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </thead>
                    <tbody>
                        <?php
                        $select_products = mysqli_query($conn, "SELECT * FROM donhang WHERE trangthai = 'Đang chờ xác nhận hủy đơn hàng'");

                        if (mysqli_num_rows($select_products) > 0) {
                            while ($row = mysqli_fetch_assoc($select_products)) {
                                $iddh = $row['iddh'];
                                $trangthai = $row['trangthai'];
                                $ngaydathang = $row['ngaydathang'];
                        ?>
                                <tr>
                                    <form class="orderForm" method="post" action="">
                                        <td style="text-align: center;"><?php echo $row['iddh']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                        <td><?php echo $row['tongtien']; ?></td>
                                        <td><a href="chitietdonhang.php?iddh=<?php echo $row['iddh']; ?>">Hiển thị chi tiết</a></td>
                                        <td><?php echo $row['trangthai']; ?></td>
                                        <?php
                                        if ($trangthai != 'Đã hủy đơn hàng' && $trangthai != 'Đã giao') {
                                            echo '<input type="hidden" name="iddh" value="' . $iddh . '">';
                                            echo '<td><a href="donhang.php?suatrangthai=' . $row['iddh'] . '"> <i class="fas fa-edit"></i> Sửa trạng thái </a></td>';
                                        } else {
                                            echo '<td></td>';
                                        }
                                        ?>



                                    </form>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
        
        </section>
<!-- ============================================================================================== -->
        <button class="btnk" onclick="toggleSection('donHangDaHuySection')" style="text-align: center;padding: 10px; font-weight: bold;">Đơn hàng đã hủy</button>
        <section id="donHangDaHuySection" class="display-product-table" style="display: none;">
            <table class="table table-striped">
                <thead>
                    <th>Mã đơn</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Trạng thái</th>
                </thead>
                <tbody>
                    <?php
                    $select_products = mysqli_query($conn, "SELECT * FROM donhang WHERE trangthai = 'Đã hủy đơn hàng'");

                    if (mysqli_num_rows($select_products) > 0) {
                        while ($row = mysqli_fetch_assoc($select_products)) {
                            $iddh = $row['iddh'];
                            $ngaydathang = $row['ngaydathang'];
                    ?>
                            <tr>
                                <form action="" method="post">
                                    <td style="text-align: center;"><?php echo $row['iddh']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                    <td><?php echo $row['tongtien']; ?></td>
                                    <td><a href="chitietdonhang.php?iddh=<?php echo $row['iddh']; ?>">Hiển thị chi tiết</a></td>
                                    <td><?php echo $row['trangthai']; ?></td>
                                </form>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <script>
            function toggleSection(sectionId) {
                var section = document.getElementById(sectionId);
                if (section.style.display === "none") {
                    section.style.display = "block";
                } else {
                    section.style.display = "none";
                }
            }
        </script>
    </section>





</body>

</html>