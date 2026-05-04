<?php

require("protected/functions/gps.php");

//include yii config file
$config = include("protected/config/main.php");

$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
$id=$_GET['id'];
$userId="{$_GET['userId']}";

$code = "<markers>";

$dbHost=$config['params']['dbHost'];

// Opens a connection to a mySQL server
$connection=mysql_connect ($dbHost, $username, $password);
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $connection);

if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active mySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}


// Select all the rows in the markers table
header("Content-type: text/xml");

if ($id == 1){
 $where = "";
}else{
	$where = "WHERE v.company_id=$id";
	// User Group Exceptions
	if ($userId==8){
		$where = "WHERE t.device_id='1010001001'";
	}
	if ($userId==9){
		$where = "WHERE t.device_id='1010000392' or  t.device_id='1010000432'";
	}
	if ($userId==11){
		$where = "WHERE t.device_id='1010001002'";
	}
	if ($userId==26){
		$where = "WHERE t.device_id = '1010006001' or t.device_id = '1010006002' or t.device_id = '1010006003' or t.device_id = '1010006005' or t.device_id = '1010006006' or t.device_id = '1010006007' or t.device_id = '1010006009' or t.device_id = '1010006024' or t.device_id = '1010006008'";
	}
	if ($userId==28){
		$where = "WHERE  t.device_id = '1010006021' or t.device_id = '1010006004' or t.device_id = '1010006023'";
	}
}
		
		$query = "SELECT t.device_id, t.longitude, t.latitude, t.address, t.direction , v.serial, t.gps_datetime, t.speed, t.last_connection , t.input_status  
					FROM latest_points AS t 
					LEFT JOIN device AS d ON d.id = t.device_id
					LEFT JOIN vehicle AS v ON d.id = v.device_id
					$where";
					
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query: ' . mysql_error());
		}
		
		
		
		// Iterate through the rows, adding XML nodes for each
		while ($row = @mysql_fetch_assoc($result)){

		  $datetime = reformDateTime($row['gps_datetime']);
		  
		  $status = getCarMapStatus($row['last_connection']);
		  
		  $code .= "<marker device_id='{$row['device_id']}' 
		  					longitude='{$row['longitude']}' 
							latitude='{$row['latitude']}' 
							address='{$row['address']}'
							direction='{$row['direction']}' 
							vehicle_number='{$row['serial']}' 
							datetime='$datetime'
							speed='{$row['speed']}'
							status='$status' 
                                                        ignition='{$row['input_status']}'
							/>";
		}
		

		
		$code .= "</markers>";



echo $code;

?>

