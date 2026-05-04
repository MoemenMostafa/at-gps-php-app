<?php

require("protected/functions/gps.php");

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

//include yii config file
$config = include("protected/config/main.php");

$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
$dbHost=$config['params']['dbHost'];

$company_id= $_GET['company_id'];
$location_id=$_GET['location_id'];
$timezone =$_GET['timezone'];
$now = date('Y-m-d H:i:s');

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



if ($company_id >0){
	$query = "SELECT points
                        FROM location
                        WHERE id =  $location_id
					 ";
	
	$result = mysql_query($query);
	if (!$result) {
	  die('Invalid query: ' . mysql_error());
	}
                
            while ($row = @mysql_fetch_assoc($result)){
                
                $points = $row['points'];
                // Prepare polygon points for the class 
                $points = explode("),(",$points);
                $points = str_replace(array("(",")"),"",$points);
                $polygon = str_replace(array(","),"",$points);
                
                #print_r($polygon);
                
            }
            
            $query = "SELECT lp.longitude, lp.latitude, v.serial, lp.device_id
                        FROM latest_points as lp
                        LEFT JOIN vehicle as v on v.device_id = lp.device_id 
                        WHERE v.company_id =  $company_id
					 ";
	
            $result = mysql_query($query);
            if (!$result) {
              die('Invalid query: ' . mysql_error());
            }
                
                $pointLocation = new pointLocation();
                while ($row = @mysql_fetch_assoc($result)){
                    $point = $row['latitude']." ".$row['longitude'];
                    if ($pointLocation->pointInPolygon($point, $polygon)==1){
                        $vehicles[$row['serial']] = $row['device_id'];
                    }
                }
                ksort($vehicles);
                echo json_encode($vehicles);
        }
	
	

?>