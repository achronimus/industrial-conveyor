<?php 

    require "koneksidb.php";  
    $counts = query("SELECT * FROM tabel_device");

 ?>
 

 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
  
  
       <div class="row mx-1 my-3">  
          <?php foreach ($counts as $count) :
                if ($count["btn_state"] == 0) {
                  $status = "ON";
                }
                else{
                  $status = "OFF";
                }
                if ($count["max"] == 0) {
                  $max = '-';
                }
                else{
                  $max = $count["max"];
                }

                if ($count["start_time"] != 0)  {
                  if ($count["end_time"] == 0) {
                    $timestamp = date("H:i:s", time() - $count["start_time"] - $det);
                  }
                  else{
                    $timestamp = date("H:i:s", $count["end_time"] - $count["start_time"] - $det);
                  }  
                } 
                else{
                  $timestamp  = "00:00:00"; 
                }
          ?>
           <div class="col-sm-3">
            <div class="card mb-3" style="max-width:22rem;">
              <h5 class="card-header text-white" style="background-color:#b80d0d"> <?= $count["device"] ?> </h5>
                 <div class="card-body">
                        
                          <div class="col">
                               <p class="text-center" style="font-weight: bold; font-size: 50px;">
                                 <i class="fa fa-cogs"></i> <?=$count["count"];?>
                               </p>
                          </div>
                          
                            <table class="text-center" style="width: 15rem; ">
                                <tr>
                                   <th>Mode</th>
                                   <th>Status</th>
                                   <th>Limit</th>
                                </tr>
                                <tr>
                                   <td><?=$count["mode"];?></td>
                                   <td><?=$status;?></td>
                                   <td><?=$max;?></td>
                                </tr>
                            </table>
                          
                        
                  </div>
                  <div class="card-footer" style="font-weight: bold; font-size: 18px;">
                      <i class="fa fa-stopwatch"></i> <?= $timestamp;?>
                  </div>
              </div>
            </div>
         <?php endforeach; ?>
        </div>
      

      

 </body>
 </html>
