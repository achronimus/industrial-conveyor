<?php 

require "koneksidb.php";
session_start();

if (!isset($_SESSION["login"])) {
    header("location:index.php");
    exit;
}

if(isset($_GET["Tanggal1"]) AND isset($_GET["Tanggal2"])){
  $Tanggal1  = mysqli_escape_string($koneksi, $_GET["Tanggal1"]); $waktu1 = $Tanggal1." 00:00:00";
  $Tanggal2  = mysqli_escape_string($koneksi, $_GET["Tanggal2"]); $waktu2 = $Tanggal2." 23:59:59"; 
}
else if(!isset($_GET["Tanggal1"]) AND !isset($_GET["Tanggal2"])){
  $Tanggal1  = date("Y-m-d"); $waktu1 = $Tanggal1." 00:00:00";
  $Tanggal2  = date("Y-m-d"); $waktu2 = $Tanggal2." 23:59:59"; 
}

$data = query("SELECT * FROM tabel_record WHERE waktu BETWEEN '$waktu1' AND '$waktu2' 
     ORDER BY no DESC");

// Require composer autoload
require 'vendor/autoload.php';

// Define a default Landscape page size/format by name
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'margin_top' => 0]);

$cetak = '<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  <center>
  <h2>DATA RECORD</h2>
  <table border = "1" cellpadding = "8" cellspacing = "0">
   <tr>
       <th>No.</th>
       <th>Time Submit</th>
       <th>Label</th>
       <th>Result</th>
       <th>Start Time</th>
       <th>End Time</th>
       <th>Device</th>
   </tr>';
    
    $no = 1;
    foreach ($data as $i) {
      $cetak .= '<tr>
        			       <td>'.$no.'</td>
                     <td>'.$i["waktu"].'</td>
                     <td>'.$i["label"].'</td>
                     <td>'.$i["result"].'</td>
                     <td>'.date("H:i:s", $i["start_time"]).'</td>
                     <td>'.date("H:i:s", $i["end_time"]).'</td>
                     <td>'.$i["device"].'</td>
    	           </tr>';          
       $no++;
    }
$cetak .= '</table>
            </center>
               </body>
         </html>';


// Write some HTML code:
$mpdf->WriteHTML($cetak);
// Output a PDF file directly to the browser
$mpdf->Output('data record.pdf', \Mpdf\Output\Destination::DOWNLOAD);

 ?>