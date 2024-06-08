<?php 	
	require "template.php";
  
  
  $data = query("SELECT * FROM tabel_config")[0];

//Cek tombol submit apa sudah ditekan atau belum
if(isset($_POST["simpan"]))  { //ubah username
    if(ubahUsername($_POST) > 0) {
            echo "
        <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Data username dan id telegram berhasil disimpan',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='aturakun.php'; 
                  }); 
			   </script>
                ";      
    }
    else {
		      echo "
		        <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Data username dan id telegram gagal disimpan!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='aturakun.php'; 
		            }); 
		         </script>
		        ";
    }
 }  

 //Cek tombol submit apa sudah ditekan atau belum
if(isset($_POST["ubah"]))  { //pengaturan admin
    if(ubahPassword($_POST) > 0) {                  
            echo "
                 <script>
				  Swal.fire({ 
                  title: 'SELAMAT',
                  text: 'Password telah berhasil diubah',
                  icon: 'success', buttons: [false, 'OK'], 
                  }).then(function() { 
                  window.location.href='aturakun.php'; 
                  }); 
			     </script>
                ";      
    }
    else {
		      echo "
		        <script> 
		         Swal.fire({ 
		            title: 'OOPS', 
		            text: 'Password telah gagal diubah!!!', 
		            icon: 'warning', 
		            dangerMode: true, 
		            buttons: [false, 'OK'], 
		            }).then(function() { 
		                window.location.href='aturakun.php'; 
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
 		<h3>ACCOUNT PANEL</h3>

 	   <div class="container my-5" style="width:23rem;">
 		<form method="post" action="aturakun.php">	
		 		  <div class="form-group">
            <div class="input-group mb-3">
              <div class="input-group-prepend"><span class="input-group-text">ID Telegram</span></div>
                 <input type="text" autocomplete="off" class="form-control"name = "id_telegram" placeholder="Masukkan ID Telegram" value="<?=$data["id_telegram"]?>">
            </div>
  					<div class="input-group mb-3">
  					  <div class="input-group-prepend"><span class="input-group-text">Username</span></div>
  					     <input type="text" autocomplete="off" class="form-control"name = "username" placeholder="Masukkan username" value="<?=$data["username"]?>">
  					</div>
  				   <div class="input-group mb-3">
  		            <input class="form-control" name="password" type="password" autocomplete="off" placeholder="Input Password">
  		      </div>
		      </div>
        <button type="button" class="btn btn-block btn-primary" href="#ubahPassword" data-toggle="modal"data-target="#ubahPassword"><i class="fa fa-lock"></i> Change Password</button><br>
				<button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        <button type="submit" name="reset" class="btn btn-danger"><i class="fa fa-undo"></i> Reset</button> 
          </form>
		</div>     

 	</center>

 	<!-- Modal Atur Password -->
<div class="modal fade" id="ubahPassword" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color: #b80d0d;">
        <h5 class="modal-title"><i class="fa fa-lock"></i> CHANGE PASSWORD</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="aturakun.php" method="post">
         <div class="modal-body">
                    <div class="form-group">
                          <div class="input-group mb-3">
				               <input class="form-control" name="passlama" type="password" autocomplete="off" placeholder="Input Password">
				           </div>
				            <div class="input-group mb-3">
				               <input class="form-control" name="passbaru" type="password" autocomplete="off" placeholder="Input New Password">
				           </div>
				            <div class="input-group mb-3">
				               <input class="form-control" name="passbaru2" type="password" autocomplete="off" placeholder="Confirm New Password">
				           </div>
            </div>  
      </div>
      <div class="modal-footer">
        <button type="submit" name="ubah" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
        <button type="reset" name="reset" class="btn text-white" style="background: blue"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Cancel</button>
      </div>
     </form>
    </div>
  </div>
</div>

 </body>
 </html>