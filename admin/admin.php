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
		#content {
			font-size: 13px;
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
		<main>
			<ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check'></i>
					<span class="text">
						<h3>
							<?php
							$conn = mysqli_connect("localhost", "root", "", "cakeshop");
							$sql = "SELECT * FROM sanpham ";
							$kq = mysqli_query($conn, $sql);
							$count = mysqli_num_rows($kq);
							echo $count
							?>
						</h3>
						<p>Sản phẩm</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-calendar-check'></i>
					<span class="text">
						<h3>
							<?php
							$conn = mysqli_connect("localhost", "root", "", "cakeshop");
							$sql = "SELECT * FROM donhang ";
							$kq = mysqli_query($conn, $sql);
							$count = mysqli_num_rows($kq);
							echo $count
							?>
						</h3>
						<p>Đơn đặt hàng</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-dollar-circle'></i>
					<span class="text">

						<h3>
							<?php
							$conn = mysqli_connect("localhost", "root", "", "cakeshop");
							$sql = "SELECT * FROM donhang  WHERE trangthai = 'Đã giao'";
							$kq = mysqli_query($conn, $sql);
							$tongthunhap = 0;
							while ($row = mysqli_fetch_assoc($kq)) {
								$tongtien = $row["tongtien"];
								$tongthunhap += $tongtien;
							}
							$tongthunhap = number_format($tongthunhap, 3, '.', '.');
							?>
							<?php echo $tongthunhap ?>đ
						</h3>

						<p>Tổng thu nhập</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-calendar-check'></i>
					<span class="text">

						<h3>
							<?php
							$conn = mysqli_connect("localhost", "root", "", "cakeshop");
							$sql = "SELECT * FROM donhang WHERE trangthai = 'Đang chờ xác nhận'";
							$kq = mysqli_query($conn, $sql);
							$count = mysqli_num_rows($kq);
							echo $count
							?>
						</h3>
						<p>Đang chờ xác nhận</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-calendar-check'></i>
					<span class="text">
						<h3>
							<?php
							$conn = mysqli_connect("localhost", "root", "", "cakeshop");
							$sql = "SELECT * FROM donhang WHERE trangthai = 'Đang chuẩn bị đơn hàng'";
							$kq = mysqli_query($conn, $sql);
							$count = mysqli_num_rows($kq);
							echo $count
							?>
						</h3>
						<p>Đang chuẩn bị đơn hàng</p>
					</span>
				</li>
				<li>
					<i class='bx bx-car'></i>
					<span class="text">

						<h3>
							<?php
							$conn = mysqli_connect("localhost", "root", "", "cakeshop");
							$sql = "SELECT * FROM donhang WHERE trangthai = 'Đang giao hàng'";
							$kq = mysqli_query($conn, $sql);
							$count = mysqli_num_rows($kq);
							echo $count
							?>
						</h3>
						<p>Đang giao hàng</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-calendar-check'></i>
					<span class="text">
						<h3>
							<?php
							$conn = mysqli_connect("localhost", "root", "", "cakeshop");
							$sql = "SELECT * FROM donhang WHERE trangthai = 'Đã giao'";
							$kq = mysqli_query($conn, $sql);
							$count = mysqli_num_rows($kq);
							echo $count
							?>
						</h3>
						<p>Đã giao</p>
					</span>
				</li>

				<li>
					<i class='bx bx-bell'></i>
					<span class="text">
						<a href="quanlysanpham.php">
							<h3>
								<?php
								$conn = mysqli_connect("localhost", "root", "", "cakeshop");
								$sql = "SELECT * FROM sanpham WHERE soluongconlai = 0";
								$kq = mysqli_query($conn, $sql);
								$count = mysqli_num_rows($kq);
								echo $count
								?>
							</h3>
							<p>Sản phẩm hết hàng</p>
						</a>
					</span>
				</li>
			</ul>
			<div class="table-data">
				<div class="order" style="height: 480px;">
					<div class="head">
						<h3>Đơn hàng</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
					<table class="table table-hover">
						<thead>
							<tr>
								<th></th>
								<th>Mã đơn</th>
								<th>Họ tên</th>
								<th>Ngày đặt hàng</th>
								<th>Trạng thái</th>
								<th>Chi tiết</th>
							</tr>
						</thead>

						<tbody style="height: 300px; ">
							<?php
							$select_products = mysqli_query($conn, "SELECT * FROM donhang ORDER BY iddh DESC");
							if (mysqli_num_rows($select_products) > 0) {
								while ($row = mysqli_fetch_assoc($select_products)) {
									$iddh = $row['iddh'];
							?>
									<tr>
										<td><img src="images/pp1.jpg"></td>
										<td><?php echo $row['iddh']; ?></td>
										<td>
											<p><?php echo $row['ten']; ?></p>
										</td>
										<td><?php echo $row['ngaydathang']; ?></td>
										<td><span class="status completed"><?php echo $row['trangthai']; ?></span></td>
										<td><a href="chitietdonhang.php?iddh=<?php echo $row['iddh']; ?>">Chi tiết</a></td>
									</tr>
							<?php
								}
							}
							?>
						</tbody>
					</table>
				</div>

			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->


	

</body>

</html>