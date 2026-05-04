<?php
set_time_limit(0);
//include yii config file
$config = include("/var/www/html/atgps/protected/config/main.php");
//$config = include("../protected/config/main.php");

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
$startTime = microtime(true);

$yesterday = date("Ymd");
if ($_GET['date']){
	$yesterday = $_GET['date'];
}
		$query = "SELECT id FROM vehicle";
		$resultMain = mysql_query($query);      
        if ($resultMain) {
		
			while ($row = mysql_fetch_assoc($resultMain)){
					$vehicle_id = $row['id'];
                    $query = "Select latitude, longitude, gps_datetime FROM vehicle_points_".$vehicle_id." WHERE gps_datetime LIKE '$yesterday%'";
					$result = mysql_query($query);
				if ($result) {
					
                                        while ($row2 = mysql_fetch_assoc($result)){
											if (!$prevLat[$vehicle_id]){
                                                $distance[$vehicle_id] = 0;
                                                $prevLat[$vehicle_id] = $row2['latitude'];
                                                $prevLong[$vehicle_id] = $row2['longitude'];
                                            }else{
												$dist = distance($row2['latitude'], $row2['longitude'], $prevLat[$vehicle_id], $prevLong[$vehicle_id]);
                                                $distance[$vehicle_id] += $dist;
												$gpsDateTime = reformDateTime($row2['gps_datetime']);
                                                $prevLat[$vehicle_id] = $row2['latitude'];
                                                $prevLong[$vehicle_id] = $row2['longitude'];
                                            }
                                          
                                        }

                                        $action = mysql_query("INSERT INTO vehicle_odometer_snaps (vehicle_id, odometer, datetime)
                                                                       values    ($vehicle_id, '{$distance[$vehicle_id]}', '$gpsDateTime')");
                                        if (!$action) {
                                               die('Invalid prevDistanceQuery: ' . mysql_error());
                                        }
				}else{
                                    die('Invalid result: ' . mysql_error());
                                }


			}
			
			$action = mysql_query("TRUNCATE TABLE vehicle_odometer_snaps_today");
			if ($action) {
			
			}else{
				
			}
			
		}else{
			die('Invalid resultMain: ' . mysql_error());
		}
                

		

$finishTime = microtime(true);

$scriptTime = $finishTime - $startTime;

echo $scriptTime;


function distance($lat1, $lng1, $lat2, $lng2, $miles = false)
{
	$pi80 = M_PI / 180;
	$lat1 *= $pi80;
	$lng1 *= $pi80;
	$lat2 *= $pi80;
	$lng2 *= $pi80;

	$r = 6372.797; // mean radius of Earth in km
	$dlat = $lat2 - $lat1;
	$dlng = $lng2 - $lng1;
	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$km = $r * $c;

	return ($miles ? ($km * 0.621371192) : $km);
}

function reformDateTime($dateTime){
	$date = DateTime::createFromFormat('YmdHis', $dateTime);
	return($date->format('Y-m-d  H:i:s'));
}
?>
