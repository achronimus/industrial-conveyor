<?php 

require "koneksidb.php";

	//cek apa ada request dari mikrokontroller atau tidak
	if(isset($_GET['key_api'])){
		$id          = $_GET["id"];
	 	$config      = query("SELECT * FROM tabel_config")[0];
	 	$device      = query("SELECT * FROM tabel_device WHERE id = '$id'")[0];

	 	
	 	//Cek Nilai Sensor
	 	if ($_GET['sensor_state'] == "0" AND $device["count_state"] == "true") { 
	 	   $count       = $device["count"] + 1;
	 	   $count_state = "false";
	 	}
	 	else if($_GET["sensor_state"] == "1" AND $device["count_state"] == "false"){
	 	   $count       = $device["count"];
	 	   $count_state = "true";
	 	} 
	 	else{
	 	   $count       = $device["count"];
	 	   $count_state = $device["count_state"];
	 	}

	 	//cek key_api
	 	if ($_GET['key_api'] == $config["key_api"]) {
	 			//cek hitungan
	 			if (($device["max"] != 0 AND $count <= $device["max"]) OR 
	 				$device["max"] == 0) {
	 				if ($device["btn_state"] == 0) {
	 					updateCount($id, $count, $count_state);
	 				}
	 				
		 	    }
		 	    else{
		 	    	$count = $device["count"];
		 	    }
		 	    //Trigger sensor
		 	    if ($device["mode"] == "Auto") {
		 	    	if ($count < $device["max"] AND $device["msg_state"] == 1) {
		 	    		$btn = 0; //Conveyor ON
		 	    		$msg_state = 0;

		 	    	}
		 	    	else if ($count >= $device["max"] AND $device["msg_state"] == 0){
		 	    		$btn = 1; //Conveyor OFF
		 	    		$msg_state = 1;
		 	    		$pesan = "Object Counting Has End\n\nID = ".$device["id"]."\nDevice = ".$device["device"]."\nStatus = OFF\nResult = ".$count;
		 	    		kirimPesan($pesan, $config["id_telegram"], $config["token_bot"]);
		 	    		updateTime($id);
		 	    	}
		 	    	else {
		 	    	    $btn = $device["btn_state"];
		 	    	    $msg_state = $device["msg_state"];
		 	    	}
		 	    	updateButton($id, $btn, $msg_state);
		 	    }
		 	    //Trigger button
		 	    if ($device["mode"] == "Manual") {
		 	    	$btn = $device["btn_state"];
		 	    }
		 	    $result = ["key_api"   => "Valid",
		 		  		   "id"        => $device["id"],
		 		  		   "device"    => $device["device"],
		 		  		   "mode"      => $device["mode"],
				  	       "limit"     => $device["max"],
						   "count"     => $count,
						   "btn_state" => $btn
						  ];	
	 	}
	 	else{
	 		$result = ["key_api" => "Invalid"];
	 	}
	 	 
		$json = json_encode($result);
		echo $json;
	} 
	
 ?>