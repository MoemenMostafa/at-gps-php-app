<?php
set_time_limit(0);
include("/var/www/html/atgps/cron/initial.php");
$startTime = microtime(true);

$today = date("Ymd");
$time = date("His");

$query = "SELECT dateTime FROM vehicle_odometer_snaps_today";
$result3 = mysql_query($query);

if (mysql_num_rows($result3)!=0) {
	$lastDateBase = false;
	/*while ($row = mysql_fetch_assoc($resultMain)){
		if ($row['dateTime'] == "0000-00-00 00:00:00"){
			$lastDate =  $today.$time;
		}else{
			$lastDate = date("YmdHis",strtotime($row['dateTime']));
		}
	}*/
}else{
	$lastDateBase = true;
	$lastDate =  $today."000000";
	
}


		$query = "SELECT id FROM vehicle";
		$resultMain = mysql_query($query);      
		if ($resultMain) {
			while ($row = mysql_fetch_assoc($resultMain)){
					$vehicle_id = $row['id'];
					echo "vehicleID: ".$vehicle_id ."\r\n";
					if ($lastDateBase == false){
						$query = "SELECT dateTime FROM vehicle_odometer_snaps_today WHERE vehicle_id = $vehicle_id";
						$resultMain2 = mysql_query($query);
						while ($row3 = mysql_fetch_assoc($resultMain2)){
							if ($row3['dateTime'] == "0000-00-00 00:00:00"){
								$lastDate =  $today."000000";
							}else{
								$lastDate = date("YmdHis",strtotime($row3['dateTime']));
							}
						}
					}
					echo "lastDate: ".$lastDate."\r\n";
                    $query = "Select latitude, longitude, gps_datetime FROM vehicle_points_".$vehicle_id." WHERE (gps_datetime LIKE '$today%' and gps_datetime > $lastDate)";
					$result5 = mysql_query($query);
				if (mysql_num_rows($result5)) {
					
                                        while ($row2 = mysql_fetch_assoc($result5)){
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
										
										$query = "Select vehicle_id FROM vehicle_odometer_snaps_today WHERE vehicle_id = $vehicle_id"; 
										$result = mysql_query($query);
										if (mysql_num_rows($result)) {
											if ($lastDate ==  $today."000000"){
												$action = mysql_query("UPDATE vehicle_odometer_snaps_today SET odometer= '{$distance[$vehicle_id]}', datetime='$gpsDateTime'
																		   WHERE vehicle_id = $vehicle_id");
											}else{
												$action = mysql_query("UPDATE vehicle_odometer_snaps_today SET odometer= odometer + '{$distance[$vehicle_id]}', datetime='$gpsDateTime'
																		   WHERE vehicle_id = $vehicle_id");
										    }
										}else{
											$action = mysql_query("INSERT INTO vehicle_odometer_snaps_today (vehicle_id, odometer, datetime)
																		   values    ($vehicle_id, '{$distance[$vehicle_id]}', '$gpsDateTime')");
										}
										if (!$action) {
												   die('Invalid prevDistanceQuery: ' . mysql_error());
											}
                                        //echo "<br>--------------------<br>".$row['id']." = ".$distance[$row['id']]."<br>------------------<br><br>";
				}else{
                                    //die('Invalid result: ' . mysql_error());
                                }

				end:
			}
		}else{
			die('Invalid resultMain: ' . mysql_error());
		}
                
        	

$finishTime = microtime(true);

$scriptTime = $finishTime - $startTime;

echo $scriptTime."\r\n";


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
