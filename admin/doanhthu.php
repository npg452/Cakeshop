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
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- My CSS -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="style_qlsp.css">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Quản lý bán bánh</title>
</head>

<body>
  <?php include('sidebar.php') ?>

  <section id="content">
    <!-- NAVBAR -->
    <nav>
      <i class='bx bx-menu'></i>
      <a href="#" class="nav-link">Categories</a>


      <a href="#" class="profile">
        <img src="logo.png">
      </a>
    </nav>
    <h2 style="text-align: center;padding: 10px; font-weight: bold;">Doanh thu</h2>
  </section>

  <?php
  $con = new mysqli('localhost', 'root', '', 'cakeshop');
  $query = $con->query("
        SELECT ngaydathang,  SUM(tongtien) * 1000 as tongtien
        FROM donhang
        GROUP BY ngaydathang
    ");

  foreach ($query as $data) {
    $ngaydathang[] = $data['ngaydathang'];
    $tongtien[] = $data['tongtien'];
  }
  ?>



  <br>
  <div style="width: 500px; margin-left: 500px;">
    <canvas id="myChart"></canvas>
  </div>

  <script>
    const labels = <?php echo json_encode($ngaydathang) ?>;
    const data = {
      labels: labels,
      datasets: [{
        label: 'Tổng tiền',
        data: <?php echo json_encode($tongtien) ?>,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(94, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(75, 55, 94, 0.2)',
          'rgba(75, 204, 75, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)',
          'RGBA( 95, 294, 200, 0.2)'
        ],
        borderColor: [
          'rgb(255, 99, 132)',
          'rgb(94, 159, 64)',
          'rgb(255, 205, 86)',
          'rgb(75, 192, 192)',
          'rgb(75, 55, 94)',
          'rgb(75, 204, 75)',
          'rgb(54, 162, 235)',
          'rgb(153, 102, 255)',
          'rgb(201, 203, 207)',
          'RGBA( 95, 294, 200)'
        ],
        borderWidth: 1
      }]
    };

    const config = {
      type: 'bar',
      data: data,
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      },
    };

    var myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  </script>
  <!-- =========================================================================================================== -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

  <canvas id="myChart1" style="width:100%;max-width:800px; margin-left: 400px;"></canvas>
  <?php
  $con = new mysqli('localhost', 'root', '', 'cakeshop');

  $sql1 = "
    SELECT sanpham.tensanpham, SUM(chitietdonhang.soluong) AS soluongdaban
    FROM sanpham
    INNER JOIN chitietdonhang ON sanpham.id = chitietdonhang.idsp
    GROUP BY sanpham.id ";

  $query1 = mysqli_query($con, $sql1);

  foreach ($query1 as $data) {
    $tensanpham[] = $data['tensanpham'];
    $soluongdaban[] = $data['soluongdaban'];
  }
  ?>
  <script>
    var xValues = <?php echo json_encode($tensanpham); ?>;
    var yValues = <?php echo json_encode($soluongdaban); ?>;
    var barColors = [
      'rgba(255, 99, 132, 0.2)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(255, 99, 132)',
      'rgba(75, 192, 192, 0.2)',
      'rgb(75, 192, 192)',
      'rgba(54, 162, 235)',
      'rgba(153, 157, 192)',
      'rgb(153, 102, 255)',
      'rgba(201, 203, 207, 0.2)',
      'rgb(0,100,0)',
      'rgb(255, 225, 86)',
      'rgb(54, 162, 235)',
      'rgb(201, 203, 207)',
      'rgba(67, 255, 100, 0.85)',
      'RGBA( 153, 50, 204, 1 )',
      'RGBA( 143, 188, 143, 1 )',
      'RGBA( 0, 191, 255, 1 )',
      'RGBA( 0, 128, 0, 1 )',
      'RGBA( 240, 230, 140, 1 )'
    ];

    new Chart("myChart1", {
      type: "pie",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          data: yValues
        }]
      },
      options: {
        title: {
          display: true,
          text: "Số lượng sản phẩm đã bán"
        }
      }
    });
  </script>

</body>

</html>