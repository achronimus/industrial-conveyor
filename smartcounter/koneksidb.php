<?php   

$server       = "localhost";
$user         = "root";
$password     = "";
$database     = "counter"; //Nama Database di phpMyAdmin

$koneksi      = mysqli_connect($server, $user, $password, $database);

//Zona Waktu
$Zona = 'Asia/Jakarta'; //Silakan disesuaikan dengan zona waktu wilayah masing-masing
date_default_timezone_set($Zona);

  if ($Zona == 'Asia/Jakarta') { //WIB
    $det = 25200; //7 jam 
  }
  else if ($Zona == 'Asia/Makassar') { //WITA
    $det = 28800; //8 jam 
  }
  else if ($Zona == 'Asia/Jayapura') { //WIT
    $det = 32400; //9 jam 
  }


function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $box = [];
    while($sql = mysqli_fetch_assoc($result)){
          $box[] = $sql;
    }
    return $box;
}

function aturToken ($post) {
    global $koneksi;
    $token_bot  = htmlspecialchars($post ['token_bot']);
    $key_api    = htmlspecialchars($post ['key_api']);
    $password   = query("SELECT * FROM tabel_config")[0];
    $password_2 = mysqli_real_escape_string($koneksi, $post["Password"]);
              
    if(password_verify($password_2, $password["password"])){
    //update data ke tabel data_config
      $query = "UPDATE tabel_config SET token_bot = '$token_bot', key_api = '$key_api'";  
      mysqli_query($koneksi, $query);
      return mysqli_affected_rows($koneksi);
    }
}

function tambahDevice($post) {
    global $koneksi;
    $device      = htmlspecialchars($post["device"]);
    $mode        = "Manual";
    $btn         =  1;
    $count_state =  "true";
    //insert data ke dalam tabel_device
    $sql = "INSERT INTO tabel_device(device, mode, count_state, btn_state) VALUES(
            '$device', '$mode', '$count_state', $btn)";
    mysqli_query($koneksi, $sql);
    return mysqli_affected_rows($koneksi);
}

function hapusDevice ($id) {
      global $koneksi;
      mysqli_query($koneksi, "DELETE FROM tabel_device WHERE id = '$id'");
      return mysqli_affected_rows($koneksi);
 }

function ubahRecord ($post) {
      global $koneksi;
      $no     = htmlspecialchars($post ['no']);
      $label  = htmlspecialchars($post ['label']);
      $result = htmlspecialchars($post ['result']);
      //update data tabel_record
      $query = "UPDATE tabel_record SET label = '$label', result = '$result' WHERE no = '$no'";
      mysqli_query($koneksi, $query);
      return mysqli_affected_rows($koneksi);
}

function hapusRecord ($no) {
      global $koneksi;
      mysqli_query($koneksi, "DELETE FROM tabel_record WHERE no = '$no'");
      return mysqli_affected_rows($koneksi);
 }


 function setDevice ($post) {
      global $koneksi;
      $id     = htmlspecialchars($post['id']);
      $device = htmlspecialchars($post['device']);
      $max    = htmlspecialchars($post ['max']);
     //update data tabel_device
      $query = "UPDATE tabel_device SET device = '$device', max = '$max' WHERE id = '$id'";
      mysqli_query($koneksi, $query);
      return mysqli_affected_rows($koneksi);
 }



 function submitData ($post) {
      global $koneksi;
      $id     = htmlspecialchars($post['id']);
      $time   = date("Y-m-d H:i:s");
      $label  = htmlspecialchars($post['label']);
      $device = htmlspecialchars($post['device']);
      $result = htmlspecialchars($post['result']);
      $start  = htmlspecialchars($post['start_time']);
      $end    = htmlspecialchars($post['end_time']);

      if($result != 0){
          //insert tabel_record
          $query = "INSERT INTO tabel_record(waktu, label, device, result, start_time, end_time) 
                    VALUES('$time','$label', '$device', '$result', '$start', '$end')";
          mysqli_query($koneksi, $query);
          //update tabel_device
          $query2 = "UPDATE tabel_device SET count = 0, start_time = 0, end_time = 0 WHERE id = $id";
          mysqli_query($koneksi, $query2);
          return mysqli_affected_rows($koneksi);
      }
     
 }

 function resetCounter ($id) {
      global $koneksi;
     //update data tabel_device
      $query = "UPDATE tabel_device SET count = 0, start_time = 0, end_time = 0 WHERE id = $id";
      mysqli_query($koneksi, $query);
      return mysqli_affected_rows($koneksi);
 }


 function ubahUsername ($post) {
      global $koneksi;
      $login       =  query("SELECT * FROM tabel_config")[0];
      $username    =  htmlspecialchars($post ["username"]);
      $id_telegram =  htmlspecialchars($post ["id_telegram"]);
      $Password    =  mysqli_real_escape_string($koneksi, $post["password"]);
              
      //cek password
      if(password_verify($Password, $login["password"])){
         $query = "UPDATE tabel_config SET id_telegram = '$id_telegram', username = '$username'";
         mysqli_query($koneksi, $query);
         return mysqli_affected_rows($koneksi);
      }
  }

  function updateCount($id, $count, $count_state){
    global $koneksi;
    $sql = "UPDATE tabel_device SET count = '$count', count_state = '$count_state'
            WHERE id = '$id'";
    $koneksi->query($sql);
    return $koneksi;
  }

  function updateButton($id, $btn, $msg_state){
    global $koneksi;
    $sql = "UPDATE tabel_device SET btn_state = $btn, msg_state = $msg_state WHERE id = '$id'";
    $koneksi->query($sql);
    return $koneksi;
  }


  function updateTime($id){
    global $koneksi;
    $time = time();
    $sql = "UPDATE tabel_device SET end_time = $time WHERE id = '$id'";
    $koneksi->query($sql);
    return $koneksi;
  }

  function ubahPassword ($post) {
      global $koneksi;
      $login      =  query("SELECT * FROM tabel_config")[0];
      $passlama   =  mysqli_real_escape_string($koneksi, $post["passlama"]);
      $passbaru   =  mysqli_real_escape_string($koneksi, $post["passbaru"]);
      $passbaru2  =  mysqli_real_escape_string($koneksi, $post["passbaru2"]);
      //cek password
      if(password_verify($passlama, $login["password"]) AND $passbaru == $passbaru2 ){
         $password = password_hash($passbaru, PASSWORD_DEFAULT);//enkripsi password
         //set password baru ke tabel login
         $query = "UPDATE tabel_config SET password = '$password'";
         mysqli_query($koneksi, $query);
         return mysqli_affected_rows($koneksi);
      }            
  }

  function resetPassword ($post) {
      global $koneksi;
      $anggota    =  query("SELECT * FROM tabel_config")[0];
      $passbaru   =  mysqli_real_escape_string($koneksi, $post["passbaru"]);
      $passbaru2  =  mysqli_real_escape_string($koneksi, $post["passbaru2"]);

      //cek password
      if($passbaru == $passbaru2 ){
        $password = password_hash($passbaru, PASSWORD_DEFAULT);//enkripsi password
        //set password baru ke tabel_config
        $query = "UPDATE tabel_config SET password = '$password'";
        mysqli_query($koneksi, $query);
        return mysqli_affected_rows($koneksi);
      }
  }

  
  function kirimPesan($pesan, $id_telegram, $token_bot) {
      $url = "https://api.telegram.org/bot" . $token_bot . "/sendMessage?parse_mode=markdown&chat_id=" . $id_telegram;
      $url = $url . "&text=" . urlencode($pesan);
      $ch = curl_init();
      $optArray = array(
           CURLOPT_URL => $url,
           CURLOPT_RETURNTRANSFER => true
          );
      curl_setopt_array($ch, $optArray);
      $result = curl_exec($ch);
      curl_close($ch);
  }

 

 

 ?>