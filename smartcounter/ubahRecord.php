<?php 
require "template.php";

if(isset($_POST["ubah"]))  {
    if(ubahRecord($_POST) > 0) {
            echo "
                 <script> 
			        Swal.fire({ 
			            title: 'SUCCESS!!!',
			            text: 'Data has changed',
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
            text: 'Data Failed!!!', 
            icon: 'warning', 
            dangerMode: true, 
            buttons: [false, 'OK'], 
            }).then(function() { 
                window.location.href='datarecord.php'; 
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
		<h3 class="mb-4 mt-2">EDIT DATA</h3>

		   <?php 
               if(isset($_GET["no"])){
               	 $no = $_GET["no"]; 
                 $data = query("SELECT * FROM tabel_record WHERE no = '$no'")[0];
           ?>
				 
				    <div class="container responsive-sm" style="width: 23rem;">
					  <form method="post" action="ubahRecord.php">
	  					<table class="table">
						    	<tr>
						    		<input type="text" name="no" value="<?=$no;?>" hidden>
						    		<th>Label</th>
						    		<td><input class="text-center" type="text" name="label" value="<?=$data['label'];?>" autocomplete = "off" required></td>
						    	</tr>	
						    	<tr>
						    		<th>Result</th>
						    		<td><input class="text-center" type="text" name="result" value="<?=$data['result'];?>" autocomplete = "off" required></td>
						    	</tr>
						 </table> 
						 <button type="submit" name="ubah" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
						  <a href="datarecord.php" type="button" class="btn btn-danger"><i class="fa fa-undo"></i> Cancel</a>
					   </form>
			         </div>
			        
             <?php  
			    }
			 ?>

     
	</center>

</body>
</html>