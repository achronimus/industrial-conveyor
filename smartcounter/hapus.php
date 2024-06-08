<?php

require "template.php"; 


    if(isset($_GET["id"])){    
        if( hapusDevice($_GET ["id"]) > 0 ) {
              echo "
                 <script>
                       Swal.fire({ 
                          title: 'SUCCESS!!!',
                          text: 'Data Device Has Deleted',
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
                      text: 'Failed to Delete', 
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

  if(isset($_GET["no"])){    
        if( hapusRecord($_GET ["no"]) > 0 ) {
              echo "
                 <script>
                       Swal.fire({ 
                          title: 'SUCCESS!!!',
                          text: 'Data Record Has Deleted',
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
                      text: 'Failed to Delete', 
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

  

$koneksi->close();

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>';



 ?>