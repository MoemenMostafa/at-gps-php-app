<?php

require("protected/functions/gps.php");

//include yii config file
$config = include("protected/config/main.php");

$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
$id=$_GET['id'];
$dbHost=$config['params']['dbHost'];

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


$query = "INSERT INTO latest_points (address)
			VALUES ('test')
			WHERE device_id=1010000001";
			
mysql_query($query);
?>