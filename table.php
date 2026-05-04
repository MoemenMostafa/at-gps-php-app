<?php

//include yii config file
$config = include("protected/config/main.php");

$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
$device_id=$_GET['device_id'];
$now = date('Y-m-d H:i:s');
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



if ($device_id >0){
	$query = "SELECT r.name AS route, dr.name AS driver
					FROM device AS d
					LEFT JOIN vehicle AS v ON v.device_id = d.id
					LEFT JOIN trip AS tr ON tr.vehicle_id = v.id
					LEFT JOIN route AS r ON r.id = tr.route_id
					LEFT JOIN driver AS dr ON dr.id = tr.driver_id
					WHERE d.id =  $device_id AND tr.from < '$now' AND tr.to > '$now' 
					OR  
					d.id =  $device_id AND tr.to = 0
					 ";
	$result = mysql_query($query);
	
	$result = mysql_query($query);
	if (!$result) {
	  die('Invalid query: ' . mysql_error());
	}
		$route= "-";
		$driver = "-";
	while ($row = @mysql_fetch_assoc($result)){
		$route= $row['route'];
		$driver = $row['driver'];
	}

	
	$query = "SELECT t.device_id, t.address, v.serial, t.gps_datetime, t.speed,  t.last_connection 
					FROM latest_points AS t 
					LEFT JOIN device AS d ON d.id = t.device_id
					LEFT JOIN vehicle AS v ON d.id = v.device_id

				WHERE t.device_id =  $device_id";
				
	$result = mysql_query($query);
	if (!$result) {
	  die('Invalid query: ' . mysql_error());
	}

	
	


$row = @mysql_fetch_assoc($result);

	$date= reformDateTime($row['gps_datetime']);
	$status = getStatus($row['gps_datetime'],$row['last_connection']);
}
	echo "<table  class='table table-striped table-bordered table-hover'>
				<tr><td>Time:</td><td>$date</td></tr>
				<tr  class='odd'><td>Speed:</td><td>{$row['speed']} Km/h</td></tr>
				<tr  class='odd'><td>Route:</td><td>$route</td></tr>
				<tr  class='even'><td>Address:</td><td>{$row['address']}</td></tr>
				<tr  class='odd'><td>Driver:</td><td>$driver</td></tr>
				<tr  class='even'><td>Status:</td><td><div style='{$status['style']}' title='{$status['title']}'></div></td></tr>
		</table>"	;

?>