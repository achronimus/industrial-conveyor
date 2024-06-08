<?php 
require "template.php";

if(isset($_POST["ubah"]))  {
    if(setDevice($_POST) > 0) {
            echo "
                 <script> 
			        Swal.fire({ 
			            title: 'SUCCESS!!!',
			            text: 'Data has changed',
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
            text: 'Data Failed!!!', 
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



 ?>

 <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<center>
		<h3 class="mb-4 mt-2">SET DEVICE</h3>

		   <?php 
               if(isset($_GET["id"])){
               	 $id = $_GET["id"]; 
                 $data = query("SELECT * FROM tabel_device WHERE id = '$id'")[0];
           ?>
				 
				    <div class="container responsive-sm" style="width: 23rem;">
					  <form method="post" action="setDevice.php">
	  					<table class="table">
						    	<tr>
						    		<input type="text" name="id" value="<?=$id;?>" hidden>
						    		<th>Device</th>
						    		<td><input class="text-center" type="text" name="device" value="<?=$data['device'];?>" autocomplete = "off" required></td>
						    	</tr>	
						    	<tr>
						    		<th>Limit</th>
						    		<td><input class="text-center" type="number" name="max" value="<?=$data['max'];?>" autocomplete = "off" required></td>
						    	</tr>
						 </table> 
						 <button type="submit" name="ubah" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
						  <a href="device.php" type="button" class="btn btn-danger"><i class="fa fa-undo"></i> Cancel</a>
					   </form>
			         </div>
			        
             <?php  
			    }
			 ?>

     
	</center>

</body>
</html>