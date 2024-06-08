<?php 
require "template.php";

if(isset($_POST["simpan"]))  {
    if(submitData($_POST) > 0) {
            echo "
                 <script> 
			        Swal.fire({ 
			            title: 'SUCCESS!!!',
			            text: 'Data has saved',
			            icon: 'success', buttons: [false, 'OK'], 
			            }).then(function() { 
			                window.location.href='datarecord.php'; 
			            });  
				</script>
                ";   
        }
                
   
    else {
      echo "
         <script> 
         Swal.fire({ 
            title: 'OOPS!!!', 
            text: 'Data fail to saved', 
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
		<h3 class="mb-4 mt-2">SUBMIT DATA</h3>

		   <?php 
               if(isset($_GET["id"])){
               	 $id = $_GET["id"]; 
               	 $data = query("SELECT * FROM tabel_device WHERE id = '$id'")[0];
                 
           ?>
				 
				    <div class="container responsive-sm" style="width: 22rem;">
					  <form method="post" action="submitData.php">
	  					<table class="table">
						   <tr>
						        <th>Label</th>
						    	<td ><input type="text" name="label" style="width: 10rem;" autocomplete = "off" required></td>
						    </tr>
						    <tr>
						    	<th>ID Device</th>
						    	<td ><?=$data['id'];?><input type="text" name="id" value="<?=$id;?>" hidden></td>
						    </tr>
						    <tr>
						    	<th>Device</th>
						        <td ><?=$data['device'];?><input type="text" name="device" value="<?=$data['device'];?>" hidden><td>
						    </td>
						    <tr>
						        <th>Count</th>
						        <td ><?=$data['count'];?><input type="text" name="result" value="<?=$data['count'];?>" hidden></td>
						    </tr>	
						     <tr>
						        <th>Start Time</th>
						        <td ><?= date("H:i:s", $data['start_time']);?>
						        <input type="int" name="start_time" value="<?=$data['start_time'];?>" hidden></td>
						    </tr>	
						    <tr>
						        <th>End Time</th>
						        <td ><?= date("H:i:s", $data['end_time']);?>
						        <input type="int" name="end_time" value="<?=$data['end_time'];?>" hidden></td>
						    </tr>	
						 </table> 
						 <button type="submit" name="simpan" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
						  <a href="device.php" type="button" class="btn btn-danger"><i class="fa fa-undo"></i> Cancel</a>
					   </form>
			         </div>
			        
             <?php  
			    }
			 ?>

     
	</center>

</body>
</html>