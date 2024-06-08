<?php 

session_start();

//cek cookie
if(isset($_COOKIE['login'])){
  if ($_COOKIE['login'] == 'true'){
     $_SESSION['login'] = true;
  }
}

 require 'koneksidb.php';

 $id_telegram = $_GET["id"];
 $uniqid      = $_GET["uniqid"];

 $date_now  = date("Y-m-d");

 $config  = query("SELECT * FROM tabel_config")[0];
 $TOKEN   = $config["token_bot"];
 $data    = query("SELECT * FROM reset_password WHERE id_telegram = '$id_telegram' AND uniqid = '$uniqid'")[0];


 //Cek tombol submit apa sudah ditekan atau belum
if(isset($_POST["kirim"]))  { 
    if(resetPassword($_POST) > 0) {
       header("Location:index.php?reset&id_telegram=".$_POST["id_telegram"]);                   
    }
    else {
       header("Location:index.php?gagal&id_telegram=".$_POST["id_telegram"]);
    }
 } 

 else if ($data AND $data["expdate"] !== $date_now) {
   header("Location:index.php?inactive&id_telegram=".$id_telegram);
 } 



  
 ?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">

    <!-- Font Awesome -->
     <link href="fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->

    <title>Sistem Penghitung Barang</title>
  </head>
  <body>

    <center>

     <img class="img-fluid responsive-sm mb-4 mt-4" src="img/png2.png" alt="Responsive image" style="width:350px; height:45px;">

    <!-- <h2 class="mb-4 mt-4">WATER LEVEL MONITORING</h2> -->

     <h5 class="mb-2">RESET PASSWORD</h5>
          <div class="card text-white mb-3" style="max-width: 20rem; background-color: #b80d0d">
            <div class="card-body">
              <h5 class="card-title"><i class="fa fa-cogs"></i> SMART CONVEYOR</h5>
                 <form action="reset-password.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="password" name="passbaru" class="form-control" placeholder="Password Baru"><br>
                                <input type="password" name="passbaru2" class="form-control" placeholder="Konfirmasi Password">
                                <input type="text" name="id_telegram" value="<?=$id_telegram;?>" hidden>
                            </div>
                         </div>
                     <div class="modal-footer">
                        <button type="submit" name="kirim" class="btn btn-primary btn-block"><i class="fa fa-sign-in-alt"></i> Kirim</button>
                    </div>
                </form>
            </div>
          </div>
          

       <footer><strong>Copyright &copy;2021 Rizky Project</strong></footer>

     </center>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>

    <!-- My Javascript/jQuery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/script.js"></script>

    <!-- Sweet Alert -->
    <script src="js/sweetalert2.all.min.js"></script>


  </body>
</html>