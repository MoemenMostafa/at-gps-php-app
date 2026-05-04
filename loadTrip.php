<?php
require("protected/functions/gps.php");

//include yii config file
$config = include("protected/config/main.php");

$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
$dbHost=$config['params']['dbHost'];

$vehicleId=$_GET['vehicleId'];
$dateRange=explode(" - ",$_GET['range']);
$from = explode("/",$dateRange[0]);
$from = trim($from[2]).trim($from[1]).trim($from[0])."000000";
$to = explode("/",$dateRange[1]);
$to = trim($to[2]).trim($to[1]).trim($to[0])."235959";


//echo $from." ".$to;

// Opens a connection to a mySQL server
$connection=mysql_connect ($dbHost, $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active mySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}


		$query = "SELECT longitude, latitude 
					FROM vehicle_points_$vehicleId
					WHERE gps_datetime BETWEEN $from AND $to";
					
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query: ' . mysql_error());
		}

		while ($row = @mysql_fetch_assoc($result)){
			
			$data[] =	$row;
			
		}
		
		echo json_encode($data);

mysql_close($connection);
?>