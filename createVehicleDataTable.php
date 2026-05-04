<?php
set_time_limit(0);
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
					FROM vehicle ";
					
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query2: ' . mysql_error());
		}
		
		
		
		// Iterate through the rows, adding XML nodes for each
		while ($row = mysql_fetch_assoc($result)){
		 	$query2 = "						
						CREATE TABLE IF NOT EXISTS `vehicle_points_{$row['id']}` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `device_id` int(16) NOT NULL,
						  `gps_datetime` varchar(14) NOT NULL,
						  `longitude` decimal(9,7) NOT NULL,
						  `latitude` decimal(9,7) NOT NULL,
						  `speed` int(3) NOT NULL,
						  `direction` decimal(6,3) NOT NULL,
						  `altitude` int(11) NOT NULL,
						  `satellites` int(11) NOT NULL,
						  `messageID` int(11) NOT NULL,
						  `input_status` int(11) NOT NULL,
						  `output_status` int(11) NOT NULL,
						  `analog_input1` decimal(6,3) NOT NULL,
						  `analog_input2` decimal(6,3) NOT NULL,
						  `rtc_datetime` varchar(14) NOT NULL,
						  `mileage` int(11) NOT NULL,
						  `speed_cam` int(3) DEFAULT NULL COMMENT 'Km/h',
						  `rpm_cam` int(5) DEFAULT NULL,
						  `engine_temp_cam` int(4) DEFAULT NULL COMMENT 'if more than 180 or (-) value then (ignore (bad data)) ',
						  `fuel_level_cam` int(3) DEFAULT NULL,
						  `fuel_rate_cam` int(4) DEFAULT NULL,
						  `fuel_temp_cam` int(4) DEFAULT NULL COMMENT 'if more than 180 or (-) value then (ignore (bad data)) ',
						  `oil_press_cam` int(5) DEFAULT NULL COMMENT '(KPa) ##### x 0.69',
						  `acc_pedal_cam` int(3) DEFAULT NULL COMMENT '%',
						  `axel_weight_cam` int(5) DEFAULT NULL COMMENT 'Kg',
						  `odometer_cam` int(11) DEFAULT NULL COMMENT 'Km',
						  `distance` decimal(6,2) DEFAULT NULL COMMENT 'm',
						  PRIMARY KEY (`id`),
						  KEY `fk_device_details_device` (`device_id`),
						  KEY `gps_datetime` (`gps_datetime`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
						


		
			
			
			";
			
			$result2 = mysql_query($query2);
			if (!$result2) {
			  die('Invalid query2: ' . mysql_error());
			}
			
			mysql_query("DROP TRIGGER IF EXISTS `update_latest_points_{$row['id']}`;");
			
			$query3 = "	CREATE TRIGGER  `update_latest_points_{$row['id']}` AFTER INSERT ON `vehicle_points_{$row['id']}`
						 FOR EACH ROW UPDATE latest_points
						SET gps_datetime = NEW.gps_datetime , longitude = NEW.longitude , latitude = NEW.latitude , speed = NEW.speed , direction = NEW.direction , altitude = NEW.altitude , satellites = NEW.satellites , messageID = NEW.messageID , latitude = NEW.latitude , input_status = NEW.input_status ,	output_status = NEW.output_status  ,	analog_input1 = NEW.analog_input1  ,	analog_input2 = NEW.analog_input2  ,	rtc_datetime = NEW.rtc_datetime  ,	mileage	= NEW.mileage	 ,	rpm_cam	 = NEW.rpm_cam	  , engine_temp_cam = NEW.engine_temp_cam  , fuel_level_cam = NEW.fuel_level_cam  , fuel_rate_cam = NEW.fuel_rate_cam  , fuel_temp_cam = NEW.fuel_temp_cam  ,	oil_press_cam = NEW.oil_press_cam  ,	acc_pedal_cam = NEW.acc_pedal_cam  ,	axel_weight_cam = NEW.axel_weight_cam   ,	odometer_cam = NEW.odometer_cam  
						WHERE device_id = NEW.device_id AND NEW.gps_datetime > gps_datetime AND NEW.gps_datetime < DATE_FORMAT(CURRENT_TIMESTAMP + INTERVAL 1 DAY,'%Y%m%d%H%i%s');
				
						";
			$result3 = mysql_query($query3);
			if (!$result3) {
			  die('Invalid query3: ' . mysql_error());
			}
		
		}
			echo "done";
		
		$start = 12000000;
		
		$query = "SELECT count(*)
					FROM device_details WHERE id > $start";
					
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query2: ' . mysql_error());
		}
		$row = mysql_fetch_row($result);

		// Should show you an integer result.
		$count = $row[0];
		$section = round($count/1000);
		
		for($i =0; $i < 1000 ;$i++){
			$start = $start + $section;
			$end =   $start + $section -1;
			$query = "SELECT dd.*,v.id as vehicle_id
					FROM device_details AS dd
					LEFT JOIN vehicle AS v ON dd.device_id = v.device_id
					WHERE dd.id between $start and $end";
			echo $query."\r\n";
			$result = mysql_query($query);
			if (!$result) {
			  die('Invalid query: ' . mysql_error());
			}
			while ($row = mysql_fetch_assoc($result)){
					$query2 = "INSERT INTO vehicle_points_{$row['vehicle_id']}
										(`device_id`, `gps_datetime`, `longitude`, `latitude`, `speed`, `direction`, `altitude`, `satellites`, `messageID`, `input_status`, `output_status`, `analog_input1`, `analog_input2`, `rtc_datetime`, `mileage`,`speed_cam`, `rpm_cam`, `engine_temp_cam`, `fuel_level_cam`, `fuel_rate_cam`, `fuel_temp_cam`, `oil_press_cam`, `acc_pedal_cam`, `axel_weight_cam`, `odometer_cam`)
								VALUES ({$row['device_id']},{$row['gps_datetime']},{$row['longitude']},{$row['latitude']},{$row['speed']},{$row['direction']},{$row['altitude']},{$row['satellites']},{$row['messageID']},{$row['input_status']},{$row['output_status']},{$row['analog_input1']},{$row['analog_input2']},{$row['rtc_datetime']},{$row['mileage']},{$row['speed_cam']}, {$row['rpm_cam']}, {$row['engine_temp_cam']}, {$row['fuel_level_cam']}, {$row['fuel_rate_cam']}, {$row['fuel_temp_cam']}, {$row['oil_press_cam']}, {$row['acc_pedal_cam']}, {$row['axel_weight_cam']}, {$row['odometer_cam']})";
					$result2 = mysql_query($query2);
					if (!$result2) {
					  echo('Invalid query2: ' . mysql_error());
					}
			}
			
		}
		


?>

