<?php

require "template.php";


$data = query("SELECT * FROM tabel_device"); 
$date = date('Y-m-d');


if(isset($_POST["simpan"]))  {
    if( tambahDevice($_POST) > 0 ) {
          
            echo "
                 <script> 
                      Swal.fire({ 
                        title: 'SUCCESS!!!',
                        text: 'Data has submitted',
                        icon: 'success', buttons: [false, 'OK'], 
                        }).then(function() { 
                            window.location.href='device.php'; 
                      }); 
                 </script>
                ";   
        }               
    else {
      echo "
         <script> 
             Swal.fire({ 
                title: 'OOPS!!!', 
                text: 'Data fail to submit', 
                icon: 'warning', 
                dangerMode: true, 
                buttons: [false, 'OK'], 
                }).then(function() { 
                    window.location.href='device.php'; 
              }); 
         </script>
        ";
    }
  }

  if(isset($_GET["reset"]))  {
     if (resetCounter($_GET['id']) > 0) {
        echo "
                 <script> 
                        Swal.fire({ 
                            title: 'SUCCESS!!!',
                            text: 'Counter has Reset',
                            icon: 'success', buttons: [false, 'OK'], 
                            }).then(function() { 
                                window.location.href='device.php'; 
                            });  
                  </script>
                          ";   
     }
     else {
        echo "
           <script> 
             Swal.fire({ 
                title: 'OOPS!!!', 
                text: 'Reset Failed!!!', 
                icon: 'warning', 
                dangerMode: true, 
                buttons: [false, 'OK'], 
                }).then(function() { 
                    window.location.href='device.php'; 
                }); 
           </script>
          ";
      }
           
  }
                
    

      //kontrol relay via button web
      if(isset($_GET["state"])){
            $id     = $_GET['id'];
            $state  = $_GET['state'];
            $data   = query("SELECT * FROM tabel_device WHERE id = '$id'")[0];
            
            if ($state == 0) { //ON
               $start_time = time();
               $end_time = 0;
            }
            else{
               $start_time = $data["start_time"];
               $end_time = time();
            }
            $sql = "UPDATE tabel_device SET start_time = '$start_time', end_time = '$end_time',
                   btn_state = '$state' WHERE id = '$id'";
            $koneksi->query($sql);
            
           
       }
       //Switching mode auto - manual
       if(isset($_GET["mode"])){
            $id     = $_GET['id'];
            $mode   = $_GET['mode'];
            $sql    = "UPDATE tabel_device SET mode = '$mode' WHERE id = '$id'";
            $koneksi->query($sql);
       } 



?>

<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
<body>

<!--  -->
  <center>
    <h3 class="mb-4 mt-2">DATA DEVICE</h3>
    

 <div class="row table-responsive-sm">
    <div class="col mb-2">
      <div class="btn-group">
          <button type="button" class="tambah btn btn-success mx-2" href="#tambahdevice" data-toggle="modal"data-target="#tambahdevice" data-placement="bottom" title="Add Device"><i class="fa fa-plus"></i> Device
          </button>
      </div>
    </div>
    <div class="col">
          <div class="form-group">
                <input class="form-control" id="keyword" placeholder="Insert ID or Device's Name" autocomplete="off"  type="text" style="width: 20rem;">
          </div>
    </div>
  </div>

<div id="tabeldevice">
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
</div>

</center>

<!-- Modal Tambah Device -->
<div class="modal fade" id="tambahdevice" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#b80d0d">
        <h5 class="modal-title"><i class="fa fa-plus"></i> ADD DEVICE</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="device.php" method="post">
         <div class="modal-body">
                    <div class="form-group">
                          <input class="form-control" name="device" type="text" autocomplete="off" placeholder="Labeling Device" required>
                    </div>
                          
          </div>
      <div class="modal-footer">
        <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        <button type="reset" name="reset" class="btn text-white" style="background:#F8D90F"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Cancel</button>
      </div>
     </form>
    </div>
  </div>
</div>

 <script>
      //Live Search
        var keyword = document.getElementById('keyword');
        var tabeldevice = document.getElementById('tabeldevice');
        
          keyword.addEventListener('keyup', function() {
              var xhr = new XMLHttpRequest();

              xhr.onreadystatechange = function() {
                  if(xhr.readyState == 4 && xhr.status == 200){
                   tabeldevice.innerHTML = xhr.responseText;
                  }
              }

              xhr.open('GET', 'js/tabeldevice.php?keyword='+keyword.value, true);
              xhr.send();
          });

          //send data
              function dataRelay(e){
                var xhr = new XMLHttpRequest();
                    if(e.checked){
                      xhr.open("GET", "device.php?id="+e.id+"&state= 0", true);
                    }
                    else{
                      xhr.open("GET", "device.php?id="+e.id+"&state= 1", true);
                    }
                  xhr.send();
              }
              function dataMode(e){
                var xhr = new XMLHttpRequest();
                    if(e.checked){
                      xhr.open("GET", "device.php?id="+e.id+"&mode=1", true);
                    }
                    else{
                      xhr.open("GET", "device.php?id="+e.id+"&mode=2", true);
                    }
                  xhr.send();
              }
      </script>

</body>
</html> 
