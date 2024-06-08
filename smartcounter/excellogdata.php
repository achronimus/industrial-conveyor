<?php

require "koneksidb.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("location:index.php");
    exit;
}

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Record.xls");

$Tanggal1  = mysqli_escape_string($koneksi, $_GET["Tanggal1"]); $waktu1 = $Tanggal1." 00:00:00";
$Tanggal2  = mysqli_escape_string($koneksi, $_GET["Tanggal2"]); $waktu2 = $Tanggal2." 23:59:59"; 

$data = query("SELECT * FROM tabel_record WHERE waktu BETWEEN '$waktu1' AND '$waktu2' 
        ORDER BY no DESC");


?>

<!DOCTYPE html>
 <html>
 <head>
  <title></title>
 </head>
 <body>
    <center>
       <h3>DATA RECORD</h3>
       <table class="table table-bordered table-hover table-striped" style="width:70rem;">
     <tr> 
       <th>No.</th>
       <th>Time Submit</th>
       <th>Label</th>
       <th>Result</th>
       <th>Start Time</th>
       <th>End Time</th>
       <th>Device</th>
     </tr>
  <?php 
    $no =1;
    foreach ($data as $i):
  ?>

     <tr>
          <td><?= $no;?></td>
          <td><?= $i["waktu"];?></td>
          <td><?= $i["label"];?></td>
          <td><?= $i["result"];?></td>
          <?php 
            echo '<td>'.date("H:i:s", $i["start_time"] ).'</td>';
            echo '<td>'.date("H:i:s", $i["end_time"] ).'</td>';
           ?>
          <td><?= $i["device"];?></td>
   <?php 
      $no++;
      endforeach;
    ?>
  </table>
    </center>
 </body>
 </html>