<?php 

session_start();

//cek cookie
if(isset($_COOKIE['login'])) {
  if ($_COOKIE['login'] == 'true') {
     $_SESSION['login'] = true;
  }
}

if(isset($_SESSION["login"])) {
  header("location: dashboard.php");
  exit;
}

require 'koneksidb.php';

$config = query("SELECT * FROM tabel_config")[0];


  if(isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($koneksi, "SELECT * FROM tabel_config WHERE username = '$username'");

    //cek username
    if (mysqli_num_rows($result) == 1) {

    //cek password
      $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row["password"])) {
        
        //set session
        $_SESSION["login"] = true;

        //cek remember me
        if(isset($_POST["remember"])) {
          setcookie('login', 'true', time() + 60);
        }
        header("location: dashboard.php");
        exit;
      }
    }
  
      $error = true;
  }

  if(isset($_POST["kirim"])){
  $id_telegram = $_POST["id_telegram"];
  $result      = mysqli_query($koneksi, "SELECT * FROM tabel_config WHERE id_telegram = '$id_telegram'");
  $row         = mysqli_fetch_assoc($result);  

    if($row) {
        $uniqid     = uniqid();
        $expdate    = date("Y-m-d");
        $link       = "http://192.168.1.10/smartcounter/reset-password.php?id=".$id_telegram."&uniqid=".$uniqid;
        $pesan      = "Silakan Klik link di bawah ini untuk mereset password anda\n\n".$link;
        kirimPesan($pesan, $id_telegram, $config["token_bot"]);
        $sql = "INSERT INTO reset_password (id_telegram, uniqid, expdate) VALUES 
                ('$id_telegram', '$uniqid', '$expdate')";
        $koneksi->query($sql);
        $alert = ' 
              <div class="alert bg-primary alert-dismissible fade show text-center text-white" role="alert"> Link reset password terkirim
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div> 

             ';

      }
      else{
        $alert = ' 
              <div class="alert bg-danger alert-dismissible fade show text-center text-white" role="alert"> ID Telegram tidak valid!!!
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div> 

             ';
      }
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

    <title>SMART COUNTER</title>
  </head>
  <body>

  	<center>

     <!-- <img class="img-fluid responsive-sm mb-5 mt-4" src="img/png2.png" alt="Responsive image" style="width:350px; height:45px;"> -->


     <h3 class="mb-4 mt-4">SMART COUNTER</h3> 

          <div class="card text-white mb-3" style="max-width: 20rem; background-color: #b80d0d;">
            <div class="card-body">
             <?php if(isset($error)) { ?>
                  <div class="alert bg-danger alert-dismissible fade show text-center text-white" role="alert">
                    Cek Ulang Inputan Anda!!!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
              <?php 
                  } if(isset($_GET["reset"])){
                    $pesan = "Password Berhasil Direset";
                    kirimPesan($_GET["id_telegram"], $pesan, $config["token_bot"]);
               ?>
                  <div class="alert bg-primary alert-dismissible fade show text-center text-white" role="alert">
                    Password berhasil direset
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
               <?php 
                  } if(isset($_GET["gagal"])){
                    $pesan = "Password Gagal Direset!!!";
                    kirimPesan($_GET["id_telegram"], $pesan, $config["token_bot"]);
                ?>
                  <div class="alert bg-danger alert-dismissible fade show text-center text-white" role="alert">
                     Passowrd gagal direset!!!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php 
                  } if(isset($_GET["inactive"])){
                    $pesan = "Link tidak aktif";
                    kirimPesan($_GET["id_telegram"], $pesan, $config["token_bot"]);
                ?>
                  <div class="alert bg-danger alert-dismissible fade show text-center text-white" role="alert">
                     Link tidak aktif!!!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php 
                   }
                 ?>
               <?php 
                   if(isset($_POST["kirim"])) {
                      echo "$alert";
                   } 
              ?>
              <h4 class="card-title"><i class="fa fa-cogs"></i> SMART COUNTER</h4>
                 <form action="index.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="username" name="username" class="form-control" placeholder="Username" autocomplete="off"><br>
                                <input type="password" name="password" class="form-control" placeholder="Password"></i><br> 
                            </div>
                         </div>
                     <div class="modal-footer">
                        <button type="submit" name="login" class="btn btn-primary btn-block"><i class="fa fa-sign-in-alt"></i> Login</button>
                        <button type="button" class="tambah btn btn-warning btn-block" href="#" data-toggle="modal"data-target="#resetakun"><i class="fa fa-sync-alt"></i> Forget Password</button>
                    </div>
                </form>
            </div>
          </div>



<!-- Modal Konfirmasi ID Telegram -->
<div class="modal fade" id="resetakun" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color: #b80d0d;">
        <h5 class="modal-title"><i class="fa fa-sync-alt"></i> FORGET PASSWORD</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="index.php" method="post">
         <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" name="id_telegram" type="text" autocomplete="off" placeholder="Input ID Telegram">         
                    </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" name="kirim" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Cancel</button>
      </div>
     </form>
    </div>
  </div>
</div>
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