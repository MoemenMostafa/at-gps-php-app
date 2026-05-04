<?php

//include yii config file
$config = include("protected/config/main.php");




// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

// This ID parameter is sent by our javascript client.
$id = $_GET['id'];

// Here's some data that we want to send via JSON.
// We'll include the $id parameter so that we
// can show that it has been passed in correctly.
// You can send whatever data you like.
#$data = array("Hello", $id);

// Send the data.
#echo json_encode($data);
//include yii config file
$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
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
		$query = "SELECT *
					FROM latest_points 
				 	WHERE id=$id";
					
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query2: ' . mysql_error());
		}
		
		
		
		// Iterate through the rows, adding XML nodes for each
		while ($row = mysql_fetch_assoc($result)){


		 echo json_encode($row['device_id']);
		}


?>

