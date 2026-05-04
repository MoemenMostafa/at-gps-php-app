<?php
require_once('initial.php');

$id = $_GET['id'];      // Vehicle ID
$from = $_GET['from'];  // From Date "YYYYMMDDHHiiss" GMT
$to = $_GET['to'];      // To Date "YYYYMMDDHHiiss" GMT


                $query = "SELECT *
                            FROM vehicle_points_$id as vp
                            WHERE gps_datetime BETWEEN $from AND $to";

                
               
					
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query2: ' . mysql_error());
		}
		
		
		
		// Iterate through the rows, adding XML nodes for each
                $array = array();
                while ($row = mysql_fetch_assoc($result)){
                    
                    $array[] = array(
                                    'device_id' => $row['device_id'],
                                    'gps_datetime' => $row['gps_datetime'],
                                    'longitude' => $row['longitude'],
                                    'latitude' => $row['latitude'],
                                    'speed' => $row['speed'],
                                    'direction' => $row['direction'],
                                    'altitude' => $row['altitude'],
                                    'satellites' => $row['satellites'],
                                    'messageID' => $row['messageID'],
                                    'input_status' => $row['input_status'],
                                    'output_status' => $row['output_status'],
                                    'analog_input1' => $row['analog_input1'],
                                    'analog_input2' => $row['analog_input2'],
                                    'rtc_datetime' => $row['rtc_datetime'],
                                    'mileage' => $row['mileage'],
                                    'speed_cam' => $row['speed_cam'],
                                    'rpm_cam' => $row['rpm_cam'],
                                    'engine_temp_cam' => $row['engine_temp_cam'],
                                    'fuel_level_cam' => $row['fuel_level_cam'],
                                    'fuel_rate_cam' => $row['fuel_rate_cam'],
                                    'fuel_temp_cam' => $row['fuel_temp_cam'],
                                    'oil_press_cam' => $row['oil_press_cam'],
                                    'acc_pedal_cam' => $row['acc_pedal_cam'],
                                    'axel_weight_cam' => $row['axel_weight_cam'],
                                    'odometer_cam' => $row['odometer_cam'],
                                    'last_connection' => $row['last_connection'],
                        

                                      );

		}
                $json = json_encode($array);
                echo $json;

?>

