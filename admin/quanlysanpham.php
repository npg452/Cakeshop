<?php
session_start();
@include 'config.php';

if (isset($_POST['themsp'])) {
	$tensanpham = $_POST['tensanpham'];
	$gia = $_POST['gia'];
	$giamgia = $_POST['giamgia'];
	$soluong = $_POST['soluong'];
	$image = $_FILES['image']['name'];
	$mota = $_POST['mota'];
	$iddanhmuc = $_POST['iddanhmuc'];
	$p_image_tmp_name = $_FILES['image']['tmp_name'];
	$p_image_folder = 'images/' . $image;

	$insert_query = mysqli_query($conn, "INSERT INTO `sanpham` (tensanpham, gia, giamgia, soluong, mota, image, iddanhmuc) VALUES ('$tensanpham', '$gia', '$giamgia', '$soluong', '$mota', '$image', '$iddanhmuc')") or die('Query failed');

	if ($insert_query) {
		move_uploaded_file($p_image_tmp_name, $p_image_folder);
		$message[] = 'Thêm sản phẩm thành công';
		header('location: quanlysanpham.php');
	} else {
		$message[] = 'Thêm sản phẩm không thành công';
	}
}

if (isset($_GET['xoasp'])) {
	$delete_id = $_GET['xoasp'];
	$delete_query = mysqli_query($conn, "DELETE FROM sanpham WHERE id = $delete_id") or die('Query failed');
	if ($delete_query) {
		header('location: quanlysanpham.php');
		$message[] = 'Sản phẩm đã được xóa ';
	} else {
		header('location: quanlysanpham.php');
		$message[] = 'Xóa sản phẩm không thành công';
	}
}

if (isset($_POST['update_product'])) {
	$id = $_POST['id'];
	$tensanpham = $_POST['tensanpham'];
	$gia = $_POST['gia'];
	$giamgia = $_POST['giamgia'];
	$soluong = $_POST['soluong'];

	if ($_FILES['update_p_image']['name']) {
		$file_name = $_FILES['update_p_image']['name'];
		$file_tmp = $_FILES['update_p_image']['tmp_name'];
		$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		$allowed_extensions = array("jpeg", "jpg", "png");

		if (in_array($file_ext, $allowed_extensions)) {
			$target = "images/" . basename($file_name);

			if (move_uploaded_file($file_tmp, $target)) {
				$sql_update_image = "UPDATE sanpham SET image = '$file_name' WHERE id = $id";
				mysqli_query($conn, $sql_update_image);
			} else {
				echo "Error while moving the image file.";
			}
		} else {
			echo "Only JPEG or PNG image files are supported.";
		}
	}

	$mota = $_POST['suamota'];
	$iddanhmuc = $_POST['iddanhmuc'];

	$update_query = mysqli_query($conn, "UPDATE sanpham SET tensanpham = '$tensanpham', gia = '$gia', giamgia = '$giamgia', soluong = '$soluong', mota = '$mota', iddanhmuc = '$iddanhmuc' WHERE id = '$id'");

	if ($update_query) {
		$message[] = 'Sửa sản phẩm thành công';
		header('location: quanlysanpham.php');
	} else {
		$message[] = 'Sửa sản phẩm không thành công';
		header('location: quanlysanpham.php');
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
	<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<!-- My CSS -->
	<link rel="stylesheet" href="style_qlsp.css">
	<link rel="stylesheet" href="style.css">
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
		<!-- NAVBAR -->
		<button onclick="myFunction()" style="background-color: #ae9886;border: none;height: 36px;padding: 5px 10px; margin: 10px;font-size: large;border-radius: 10px;color: white;">Thêm sản phẩm</button>
		<div class="container" id="add-product" style="display: none;">
			<section>

				<form action="" method="post" class="add-product-form" enctype="multipart/form-data">

					<input type="text" name="tensanpham" placeholder="Tên sản phẩm" class="box" required>
					<input type="text" name="gia" min="0" placeholder="Giá" class="box" required>
					<input type="text" name="giamgia" min="0" placeholder="Giảm giá" class="box">
					<input type="text" name="soluong" min="0" placeholder="Số lượng nhập vào" class="box" required>
					<label for="image" style="font-size: 15px; color: #9f9191;">Hình ảnh</label>
					<input type="file" name="image" accept="image/png, image/jpg, image/jpeg" class="box" required>
					<label for="mota" style="font-size: 15px; color: #9f9191;">Mô tả</label><br>
					<textarea id="mota" name="mota" placeholder="Nhập mô tả" style=" width: 458px; height: 50px; border: 1px solid #eae3d8; border-radius: 5px;">
					</textarea>

					<script>
						ClassicEditor
							.create(document.querySelector('#mota'))
							.catch(error => {
								console.error(error);
							});
					</script>
					<br>
					<label for="iddanhmuc" style="font-size: 15px; color: #9f9191;">Danh mục</label> <br>
					<select name="iddanhmuc" style="height: 30px;font-size: 15px;">
						<?php
						$conn = mysqli_connect("localhost", "root", "", "cakeshop");

						$sql = "SELECT * FROM danhmuc ";
						$kq = mysqli_query($conn, $sql);

						while ($row = mysqli_fetch_array($kq)) {
							echo '<option value="' . $row["id"] . '">' . $row['tendanhmuc'] . '</option>';
						}

						?>
					</select>
					<input type="submit" value="Thêm sản phẩm" name="themsp" class="btn">
				</form>

			</section>
		</div>
		<!-- MAIN -->


	</section>
	<script>
		function myFunction() {
			var x = document.getElementById("add-product");
			if (x.style.display === "none") {
				x.style.display = "block";
			} else {
				x.style.display = "none";
			}
		}
	</script>
	<!-- CONTENT -->
	<section class="display-product-table" style=" padding-left: 260px;">

		<table class="table table-striped">

			<thead style="text-align: center;">
			
				<th>Hình ảnh</th>
				<th>Tên sản phẩm</th>
				<th>Giá</th>
				<th>Giảm giá</th>
				<th>Sale</th>
				<th>Sl nhập vào</th>
				<th>Sl đã bán</th>
				<th>Sl còn lại</th>
				<th>Mô tả</th>
				<th>Ghi chú</th>
				<th>Hành động</th>
			</thead>
			<style>
				.scrollable-td {
					height: 200px;
					overflow-y: auto;
				}

				.scrollable-td1 {
					height: 700px;
					overflow-y: auto;
				}
			</style>
			<tbody>
				<?php

				$select_products = mysqli_query($conn, "SELECT * FROM sanpham ORDER BY id DESC");
				if (mysqli_num_rows($select_products) > 0) {
					while ($row = mysqli_fetch_assoc($select_products)) {
						$gia = $gia = number_format($row['gia'], 0, ',', '.');
						$giamgia = number_format($row['giamgia'], 0, ',', '.');
				?>

						<tr>
							
							<td><img src="images/<?php echo $row['image']; ?>" style="height: 150px; width: 150px" alt=""></td>
							<td style="width: 140px"><?php echo $row['tensanpham']; ?></td>
							<td><?php echo $gia; ?></td>
							<td style="text-align: center"><?php echo $giamgia; ?></td>
							<td><?php echo $row["sale"] ?></td>

							<td style="text-align: center"><?php echo $row['soluong']; ?></td>
							<td style="text-align: center; background-color:#ecc89e;">
								<?php
								$sql = "SELECT SUM(soluong) AS soluongdaban FROM chitietdonhang WHERE idsp = " . $row['id'];
								$result = mysqli_query($conn, $sql);

								if ($result) {
									$row_chitiet = mysqli_fetch_assoc($result);
									$soluongdaban = $row_chitiet['soluongdaban'];

									echo $soluongdaban;
								}
								?>
							</td>
							<td style="text-align: center;  background-color:#dcc9bf;">

								<?php
								$sql_total_quantity_sold = "SELECT SUM(soluong) AS soluongdaban FROM chitietdonhang WHERE idsp = " . $row['id'];
								$result_total_quantity_sold = mysqli_query($conn, $sql_total_quantity_sold);

								if ($result_total_quantity_sold) {
									$row_total_quantity_sold = mysqli_fetch_assoc($result_total_quantity_sold);
									$soluongdaban = $row_total_quantity_sold['soluongdaban'];

									$soluongconlai = $row['soluong'] - $soluongdaban;

									echo $soluongconlai;
									$update_soluong_query = "UPDATE sanpham SET soluongconlai = $soluongconlai WHERE id = " . $row['id'];
									mysqli_query($conn, $update_soluong_query);
								}
								?>


							</td>
							<td style="width: 300px">
								<div class="scrollable-td"><?php echo $row['mota']; ?></div>
							</td>
							<td style="font-weight: bold;">
								<?php
								if ($soluongconlai <= 0) {
									echo 'Hết hàng';
								}
								?>
							</td>
							<td>
								<a href="quanlysanpham.php?xoasp=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Bạn muốn xóa sản phẩm này');"> <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
										<path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
									</svg> </a>
								<a href="quanlysanpham.php?suasp=<?php echo $row['id']; ?>" class="option-btn"> <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
										<path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
									</svg> </a>
							</td>
						</tr>

				<?php
					};
				} else {
					echo "<div class='empty'>Thêm sản phẩm không thành công</div>";
				};
				?>
			</tbody>
		</table>

	</section>

	<section class="edit-form-container">
		<div class="scrollable-td1">
			<?php

			if (isset($_GET['suasp'])) {
				$edit_id = $_GET['suasp'];
				$edit_query = mysqli_query($conn, "SELECT * FROM sanpham WHERE id = $edit_id");
				if (mysqli_num_rows($edit_query) > 0) {
					while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
			?>

						<form action="" method="post" enctype="multipart/form-data" class="edit-product">
							<img src="photo/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
							<input type="hidden" name="id" value="<?php echo $fetch_edit['id']; ?>">
							<table>

							</table>
							Tên sản phẩm:
							<input type="text" class="box" required name="tensanpham" value="<?php echo $fetch_edit['tensanpham']; ?>">
							Giá:
							<input type="text" min="0" class="box" required name="gia" value="<?php echo $fetch_edit['gia']; ?>">
							Giảm giá:
							<input type="text" min="0" class="box" name="giamgia" value="<?php echo $fetch_edit['giamgia']; ?>">
							Số lượng nhập vào:
							<input type="text" class="box" required name="soluong" value="<?php echo $fetch_edit['soluong']; ?>">
							<input type="file" class="box" name="update_p_image" accept="image/png, image/jpg, image/jpeg">
							<label for="suamota" style="font-size: 15px; color: #9f9191">Mô tả</label><br>
							<textarea id="suamota" name="suamota" placeholder="Mô tả" style="width: 458px; height: 50px; border: 1px solid #eae3d8; border-radius: 5px;"><?php echo $fetch_edit['mota']; ?></textarea>

							<script>
								ClassicEditor
									.create(document.querySelector('#suamota'))
									.catch(error => {
										console.error(error);
									});
							</script>
							<br>

							<label for="iddanhmuc" style="font-size: 15px; color: #9f9191;">Danh mục</label> <br>
							<select name="iddanhmuc" style="height: 30px;font-size: 15px;" value="<?php echo $fetch_edit['iddanhmuc']; ?>">
								<?php
								$conn = mysqli_connect("localhost", "root", "", "cakeshop");

								$sql = "SELECT * FROM danhmuc ";
								$kq = mysqli_query($conn, $sql);

								while ($row = mysqli_fetch_array($kq)) {
									echo '<option value="' . $row["id"] . '">' . $row['tendanhmuc'] . '</option>';
								}

								?>
							</select>
							<input type="submit" value="Sửa sản phẩm" name="update_product" class="btn">
							<input type="reset" value="Thoát" id="close-edit" class="option-btn">
						</form>

			<?php
					};
				};
				echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
			};
			?>
		</div>
	</section>


	<script src="script.js"></script>
	<script>
		var closeButton = document.getElementById('close-edit');
		closeButton.addEventListener('click', function() {
			window.location.href = "quanlysanpham.php";
			var editFormContainer = document.querySelector('.edit-form-container');
			editFormContainer.style.display = 'none';
		});
	</script>
	

</body>

</html>