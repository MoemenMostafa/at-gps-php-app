<?php
$config = include("/var/www/html/atgps/protected/config/main.php");

$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
$dbHost=$config['params']['dbHost'];

ob_implicit_flush();

$year = $_GET['year'];

$year = "2024";

if (strlen($year)>4){
	echo 'year is not correct. ex. 2014';
    exit;
}


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
//$row[0] = "vehicle_points_251";
while ($row = mysql_fetch_row($result)) {

        if (substr($row[0],0,15) == "vehicle_points_"){
            $selectResult = mysql_query("DELETE FROM `$row[0]` WHERE  `gps_datetime` < '".$year."1300000000'");
            if ($selectResult){
                echo "Old Records Deleted from $row[0]\r\n";
            }
            $selectResultOpt = mysql_query("OPTIMIZE TABLE `$row[0]`");
            if ($selectResultOpt){
                echo "$row[0] has been optimized\r\n";
            }
	
        }

        
}


mysql_free_result($result);
?>