<?php
ini_set('memory_limit','1024M');

// Example: http://www.at-gps.com/export/export_data.php?vehicleId=10&from=20130512102409&to=20130612102901

//include yii config file
$config = include("../protected/config/main.php");

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


// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');
// The csv standard MIME header.
header('Content-Type: text/csv');

$vehicleId = $_POST['Vehicle']['id'];
$from = str_replace("-","",$_POST['Vehicle']['from'])."000000";
$to = str_replace("-","",$_POST['Vehicle']['to'])."235959";




                $query = "SELECT * FROM vehicle_points_$vehicleId as v
                          WHERE gps_datetime between '$from' AND '$to' limit 1";
					
		$result = mysql_query($query);
		if (!$result) {
		  echo('Invalid query: ' . mysql_error());
		}
                while ($row = mysql_fetch_assoc($result)){
                    $deviceId = $row['device_id'];
                    
                    
                }
if ($deviceId == ""){
    header("Content-Disposition: attachment;filename=No-data.AT1");
}else{
    header("Content-Disposition: attachment;filename=$deviceId--$from--$to.AT1");
}


                $query = "SELECT * FROM vehicle_points_$vehicleId as v
                          WHERE gps_datetime between '$from' AND '$to'";
					
		$result = mysql_query($query);
		if (!$result) {
		  echo('Invalid query: ' . mysql_error());
		}
	
                $x = 0;
		// Iterate through the rows, adding XML nodes for each
		while ($row = mysql_fetch_assoc($result)){
                 $time = substr($row['gps_datetime'],8,6);
                 $lat = substr(str_replace(".", "", $row['latitude']),0,8);
                 $long = substr(str_replace(".", "", $row['longitude']),0,8);
                 $date = substr($row['gps_datetime'],6,2).substr($row['gps_datetime'],4,2).substr($row['gps_datetime'],2,2);
                 
                 if ($x== 0){
                     
                     $deviceId = $row['device_id'];
                     
                     echo $deviceId."\r\n";
                     $x =1;
                 }
                    
                 echo '$GPRMC,';
                 echo $time.".999,A,";
                 echo $lat.",N,";
                 echo $long.",E,0,0,";
                 echo $date.",,*0C,RepNormal,,";
                 echo $row['speed'].",00000000,0,0,,,,,";
                            
				
                 echo "\r\n";

		}
            

?>

