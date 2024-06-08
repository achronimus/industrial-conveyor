<?php 
	require "template.php";

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


 ?>

 <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  <center>
  	<h3 class="mb-4 mt-2">DATA RECORD </h3>
  	

	<div class="row mt-3 mb-3 mx-5">
	      <div class="col">
	          <button type="button" class="tambah btn btn-danger" href="#tambahanggota" data-toggle="modal"data-target="#filter"><i class="fa fa-calendar"></i> Filter</button>
	      </div>
	      <div class="col">
	      <!-- Export data -->
	      <div class="dropdown">
	        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-download"></i> Export
	        </button>
	        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
	          <a class="dropdown-item" href="pdflogdata.php?Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-pdf"></i> PDF</a>
	          <a class="dropdown-item" href="excellogdata.php?Tanggal1=<?=$Tanggal1;?>&Tanggal2=<?=$Tanggal2;?>"><i class="fa fa-file-excel"></i> Excel</a>
	        </div>
	      </div>
	    </div>
  </div>

	
<div class="table-responsive-sm">
	<table class="table table-bordered table-hover table-striped" style="width:70rem;">
	   <tr class="text-center text-white" style="background-color: #b80d0d;"> 
		   <th>No.</th>
		   <th style="width: 180px;">Time Submit</th>
		   <th>Label</th>
		   <th>Result</th>
		   <th>Start Time</th>
		   <th>End Time</th>
		   <th>Device</th>
		   <th style="width: 100px;">Opsi</th>
	   </tr>
	<?php 
		$no =1;
		foreach ($data as $i):
	?>

	   <tr>
	   		<td class="text-center"><?= $no;?></td>
	      	<td class="text-center"><?= $i["waktu"];?></td>
	      	<td class="text-center"><?= $i["label"];?></td>
	      	<td class="text-center"><?= $i["result"];?></td>
	      	<?php 
	      		echo '<td class="text-center">'.date("H:i:s", $i["start_time"] ).'</td>';
	      		echo '<td class="text-center">'.date("H:i:s", $i["end_time"] ).'</td>';

	      	 ?>
	      	<td><?= $i["device"];?></td>
	        <td align="center">
		      <a class="ubah btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="Setting" href="ubahRecord.php?no=<?=$i["no"];?>"><i class="fa fa-edit"></i></a>
		       <a class="hapus btn-danger btn-sm alert_hapus" data-toggle="tooltip" data-placement="bottom" title="Delete" href="hapus.php?no=<?=$i["no"];?>"><i class="fa fa-trash-alt"></i>
            </td>
	      	
	 <?php 
	    $no++;
	    endforeach;
	  ?>
	</table>
</div>

  	<!-- Modal Filter Tanggal -->
<div class="modal fade" id="filter" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color: #b80d0d;">
        <h5 class="modal-title"><i class="fa fa-calendar"></i> FILTER BY DATE</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><br>
      <form method="get" action="datarecord.php">
      	  <span>Start Date</span>
			<input type="date" name="Tanggal1"><br><br>
		  <span>End Date</span>
			<input type="date" name="Tanggal2"><br>  
      <div class="modal-footer">
        <button type="submit" value="Filter" class="btn btn-success"><i class="fa fa-filter"></i> Filter </button>
        <button type="reset" name="reset" class="btn text-white" style="background:#F8D90F"><i class="fa fa-sync-alt"></i> Reset</button>
        <button type="button" class=" btn btn-danger" data-dismiss="modal"> <i class="fa fa-undo"></i> Batal</button>
      </div>
     </form>
    </div>
  </div>
</div>


  </center>	

</body>
</html>