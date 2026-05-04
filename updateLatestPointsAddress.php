<?php

require("protected/functions/gps.php");

//include yii config file
$config = include("protected/config/main.php");

$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
$dbHost=$config['params']['dbHost'];

// Opens a connection to a mySQL server
$connection=mysql_connect ($dbHost, $username, $password);
	mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $con);

	mysql_select_db($database, $con);
	
	$result = mysql_query("SELECT * FROM latest_points");
	if (!$result) {
		  die('Invalid query: ' . mysql_error());
		}
	$i = 0;
	while ($row = @mysql_fetch_assoc($result)){
		$address = getAddress($row['latitude'],$row['longitude']);
		$query = mysql_query("UPDATE latest_points SET address = '$address'  WHERE device_id = {$row['device_id']}");
		if (!$query) {
		  die('Invalid query: ' . mysql_error());
		}
		echo $row['device_id']." updated</br>";
	}
	echo "Done";

	
	//$result = mysql_query("SELECT longitude, latitude FROM latest_points WHERE device_id = '$modemID'");




?>