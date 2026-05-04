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
		$query = "SELECT id FROM vehicle WHERE company_id=11";
		$resultMain = mysql_query($query);
		
		$query = "Select id, speed_limit, name, points FROM speed_zone WHERE company_id=11 ORDER BY speed_limit DESC";
		$speedZonesResult = mysql_query($query);

		$query = "Select min(speed_limit) as msl FROM speed_zone";
		$minSpeedLimitQuery = mysql_query($query);
		while ($minSpeedLimitArray = mysql_fetch_assoc($minSpeedLimitQuery)){
				$minSpeedLimit = $minSpeedLimitArray['msl'];
			}

		echo $minSpeedLimit."\r\n";

        if ($resultMain && $speedZonesResult) {
			$pointLocation = new pointLocation();
			while ($speedZones = mysql_fetch_assoc($speedZonesResult)){
				$speedZone[] = $speedZones;
			}

			
			while ($row = mysql_fetch_assoc($resultMain)){
					$vehicle_id = $row['id'];
					echo $vehicle_id."\r\n";
                    $query = "Select latitude, longitude, gps_datetime, speed FROM vehicle_points_".$vehicle_id." WHERE gps_datetime LIKE '$yesterday%' and gps_datetime not LIKE '%000000'";
					$result = mysql_query($query);
				if ($result) {
					
                                        while ($row2 = mysql_fetch_assoc($result)){
                                        	// Check if the point speed is biger than base speed limit of all zones to filter unwanted points
                                        	if ($row2['speed'] > $minSpeedLimit){
                                        		$point = $row2['latitude']." ".$row2['longitude'];
												foreach($speedZone as $zone){
					                                // Prepare polygon points for the class
													$points = explode("),(",$zone['points']);
													$points = str_replace(array("(",")"),"",$points);
													//print_r($points);
													$polygon = str_replace(array(","),"",$points);
													$polygon[]=$polygon[0];
													$geoFence = $pointLocation->pointInPolygon($point, $polygon);
													if($row2['speed']>$zone['speed_limit'] && $geoFence == "inside"){
														$violation = true;
														if (!isset($gpsDateTimeStart[$zone['id']])){
															$gpsDateTimeStart[$zone['id']] = reformDateTime($row2['gps_datetime']);
														}
														$gpsDateTimeEnd[$zone['id']] = reformDateTime($row2['gps_datetime']);
														#echo "vehicle # $vehicle_id viloated speed limit ({$zone['speed_limit']}) with speed {$row2['speed']} at point $point in {$zone['name']}\r\n";
														#echo "prevLat= ".$prevLat[$zone['id']] ."\r\n";
														if ($prevLat[$zone['id']] && $prevLong[$zone['id']]){
															$distance[$zone['id']] += distance($prevLat[$zone['id']],$prevLong[$zone['id']],$row2['latitude'],$row2['longitude']);	
														}

														if ($maxSpeed[$zone['id']] < $row2['speed']){
															$maxSpeed[$zone['id']] = $row2['speed'];
														};

														$prevLat[$zone['id']] = $row2['latitude'];
														$prevLong[$zone['id']] = $row2['longitude'];

														break; // To get only the violation in the first zone in case that position matches 2 or more zones
													}else{
														$violation = false;
													}
													
												}
											}else{
												// Reset accumulation of time and distance of violation
												$violation = false;
											}

											if ($violation == false){
												unset($prevLat);
												unset($prevLong);
											}
											
                                        }
                                          
                                        
                                        foreach($speedZone as $zone){
											echo "Violation distance in {$zone['name']} Zone= ".$distance[$zone['id']]."\r\n";
                                        	echo "Violation maxSpeed in {$zone['name']} Zone = ".$maxSpeed[$zone['id']]."\r\n";
                                        	
                                        	if ($distance[$zone['id']]){
                                        		$action = mysql_query("INSERT INTO vehicle_speedzone_violation (vehicle_id, speed_zone_id, odometer, max_speed, datetime, datetimeEnd)
	                                                                       values    ($vehicle_id, {$zone['id']}, '".$distance[$zone['id']]."', ".$maxSpeed[$zone['id']].", '".$gpsDateTimeStart[$zone['id']]."', '".$gpsDateTimeEnd[$zone['id']]."')");
		                                        if (!$action) {
		                                               die('Invalid prevDistanceQuery: ' . mysql_error());
		                                        }
                                        	}
	                                        
	                                    }

                                        unset($distance);
                                        unset($prevLat);
                                        unset($prevLong);
                                        unset($maxSpeed);
				}else{
                                    die('Invalid result: ' . mysql_error());
                                }


			}
		}
			
// 			$action = mysql_query("TRUNCATE TABLE vehicle_odometer_snaps_today");
// 			if ($action) {
			
// 			}else{
				
// 			}
			
// 		}else{
// 			die('Invalid resultMain: ' . mysql_error());
// 		}
                

		

$finishTime = microtime(true);

$scriptTime = $finishTime - $startTime;

echo $scriptTime;


class pointLocation {
    var $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?
 
    function pointLocation() {
    }
 
    function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;
 
        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array(); 
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }
 
        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }
 
        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);
 
        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }
 
    function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
 
    }
 
    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        // y = Latitude, x = Longitude
        return array("y" => $coordinates[0], "x" => $coordinates[1]);
    }
 
}

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
