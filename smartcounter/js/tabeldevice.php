<?php 

require "../koneksidb.php";

session_start();

if (!isset($_SESSION["login"])) {
    header("location:index.php");
    exit;
}

$keyword = $_GET["keyword"];

$data =  query("SELECT * FROM tabel_device WHERE id LIKE '%$keyword%' OR device LIKE '%$keyword%'");

 ?>

 <!DOCTYPE html>
 <html>
 <head>

 	<title></title>
 </head>
 <body>

<div class="table-responsive-sm">
<table class="table table-bordered table-hover  table-striped"style="width:70rem;">
   <tr class="text-center text-white" style="background-color:#b80d0d"> 
       <th>No.</th>
       <th>ID Device</th>
       <th>Device</th>
       <th>Count</th>
       <th>Limit</th>
       <th>Start Time</th>
       <th>End Time</th>
       <th style="width: 100px;">Mode</th>
       <th style="width: 100px;">Switch</th>
       <th style="width: 100px;">Options</th>
   </tr>
<?php $i =1;?>

<?php foreach ($data as $device) :?> 
   <tr>
       <td class="text-center"><?= $i; ?></td>
       <td class="text-center"><?= $device["id"];?></td>
       <td><?= $device["device"];?></td>
       <td class="text-center"><?= $device["count"];?></td>
       
        <?php  
            if ($device["max"] == 0) {
                  $max = '-';
            }
            else{
                 $max = $device["max"];
            }
            echo'<td class="text-center">'.$max.'</td>';

            if ($device["btn_state"] == 0) { //ON
                $checked_2 = "checked";
                $start = date("H:i:s", $device["start_time"]);
                $end = "00:00:00";
            }
            else{ //OFF
                $checked_2 = "";
                $start = date("H:i:s", $device["start_time"]);
                $end = date("H:i:s", $device["end_time"]);
            }

            if ($device["start_time"] == 0) {
              $start = "00:00:00";
            }
            if ($device["end_time"] == 0) {
              $end = "00:00:00";
            }

            echo '<td class="text-center">'.$start.'</td>';
            echo '<td class="text-center">'.$end.'</td>';

            if ($device["mode"] == "Auto") {
                 $disabled  = "disabled";
                 $checked_1 = "checked";
            }
            else{
                 $disabled  = "";
                 $checked_1 = "";
            }
             echo '<td class="text-center"><input type="checkbox"'.$checked_1.' id ='.$device["id"].' onchange="dataMode(this)" data-toggle="toggle" data-on="Auto" data-onstyle="primary" data-off="Manual" data-offstyle="warning"></td>';
           
            echo '<td class="text-center"><input type="checkbox"'.$disabled.' '.$checked_2.' id ='.$device["id"].' onchange="dataRelay(this)" data-toggle="toggle" data-onstyle="success" data-offstyle="danger"></td>';
         ?>

   <td align="center">
      <div class="dropdown">
        <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown"  data-placement="bottom" title="Options" style="background-color:#F8D90F"><i class="fa fa-list-alt"></i></button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php 
                if ($device["count"] > 0 AND $device["end_time"] != 0) {
                  echo'<a class="dropdown-item btn btn-sm" href="submitData.php?id='.$device["id"].'"><i class="fa fa-save"></i> Submit</a>
                    ';
                }

                if ($device["count"] > 0 OR $device["end_time"] != 0) {
                  echo'<a class="dropdown-item btn btn-sm alert_hapus" href="device.php?reset&id='.$device["id"].'" disabled><i class="fa fa-sync-alt"></i> Reset</a> ';
                }
             ?>
            <a class="dropdown-item btn btn-sm" href="setDevice.php?id=<?=$device["id"];?>"><i class="fa fa-edit"></i> Edit</a>
            <a class="dropdown-item btn btn-sm alert_hapus" href="hapus.php?id=<?=$device["id"];?>"><i class="fa fa-trash-alt"></i> Delete</a>   
          </div>
      </div>
    </td>
   </tr>
   <?php 
        $i++; 
        endforeach; 
    ?>

</table>
</div> 	
   

 </body>
 </html>