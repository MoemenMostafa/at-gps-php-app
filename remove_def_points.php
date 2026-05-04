<?php
$config = include("/var/www/html/atgps/protected/config/main.php");

$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
$dbHost=$config['params']['dbHost'];



ob_implicit_flush();

if (!mysql_connect($dbHost, $username, $password)) {
    echo 'Could not connect to mysql';
    exit;
}

mysql_select_db($database) or die(mysql_error()); 

$sql = "SHOW TABLES FROM $database";
$result = mysql_query($sql);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

while ($row = mysql_fetch_row($result)) {
        if (substr($row[0],0,15) == "vehicle_points_"){
		$selectResult = mysql_query("DELETE FROM `$row[0]` WHERE  `device_id` = 0");
		if ($selectResult){
                    echo "Records Deleted from $row[0]\r\n";
                }
	
	
        }
}


mysql_free_result($result);
?>