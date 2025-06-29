<?php 

require 'koneksidb.php';

session_start();

if (!isset($_SESSION["login"])) {
    header("location:index.php");
    exit;
}




 ?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- My CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Font Awesome -->
    <link href="fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->

    <!-- Icon toogle switch -->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">


    <title>SMART COUNTER</title>
    <!-- Navbar -->
          <nav class="navbar fixed-top navbar-expand-sm navbar-dark ml-auto " style="background-color:#b80d0d">
            <a class="navbar-brand" href="#" style="font-size: 20px;"><i class="fa fa-cogs"></i> SMART COUNTER</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link" href="dashboard.php" ><i class="fa fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="device.php" ><i class="fa fa-cogs"></i> Device</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="datarecord.php" ><i class="fa fa-table"></i> Data Record</a>
                </li>
                <li class="nav-item">
                  <div class="dropdown">
                   <a  href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i> Setting </a>
                    <div class="dropdown-menu">
                       <a class="dropdown-item" href="auth.php"><i class="fa fa-key"></i> Authentication</a>
                      <a class="dropdown-item" href="aturakun.php"><i class="fa fa-user-lock"></i> Account</a>

                    </div>
                  </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link alert_hapus" href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
                </li>
              </ul>
            </div>
          </nav>
  </head>
  
  <body class="bg-light">
          <br><br><br>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- My Javascript/jQuery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/script.js"></script>

    <!-- Sweet Alert -->
    <script src="js/sweetalert2.all.min.js"></script>

    <!-- Icon Toogle Switch -->
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    <!-- Highchart JS -->
    <script src="https://code.highcharts.com/highcharts.js"></script>

  </body>
</html>

