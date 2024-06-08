<?php 	
	require "template.php";


  $data    = query("SELECT * FROM tabel_config")[0];

	//Cek tombol simpan apa sudah ditekan atau belum
if(isset($_POST["simpan"]))  { //pengaturan token
    if(aturToken($_POST) > 0) {
        echo "
           <script>
				        Swal.fire({ 
                  title: 'SUCCESS',
                  text: 'Data has saved',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='auth.php'; 
                }); 
			     </script>
                ";      
    }
    else {
		      echo "
		        <script> 
  		         Swal.fire({ 
  		            title: 'OOPS', 
  		            text: 'Data fail to saved', 
  		            icon: 'warning', 
  		            dangerMode: true, 
  		            buttons: [false, 'OK'], 
  		            }).then(function() { 
  		                window.location.href='auth.php'; 
  		          }); 
		         </script>
		        ";
    }
}

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>	</title>
 </head>
 <body>
 	<center>
 		<h3 class="mb-4 mt-2">AUTHENTICATION</h3>

 	
 		<form method="post" action="auth.php">	
 		  <div class="table-responsive-sm">
             <table class="table" style="width: 40rem;">
             	<tr class="text-white" style="background-color: #b80d0d;">
             		<th class="text-center">Variable</th>
             		<th class="text-center">Auth</th>
             	</tr>
             	<tr>
             		<td>Telegram</td>
             		<td><input type="text" class="form-control"name = "token_bot" autocomplete="off" value="<?=$data["token_bot"]?>"></td>
             	</tr>
             	<tr>
             		<td>Web</td>
             		<td><input type="text" class="form-control"name = "key_api" autocomplete="off" value="<?=$data["key_api"]?>"></td>
             	</tr>
              <tr>
                <td>Password</td>
                <td><input type="password" class="form-control"name = "Password" autocomplete="off" placeholder="Input Password" required></td>
              </tr>
             </table>
          </div>
				       <button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
               <button type="submit" name="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Reset</button>
          </form>
		   

 	</center>


 </body>
 </html>