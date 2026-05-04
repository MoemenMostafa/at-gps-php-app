<?php
set_time_limit(0);
//include yii config file
$config = include("/var/www/html/atgps/protected/config/main.php");

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
					FROM alert 
					where first_occurrence < DATE_SUB(now(), INTERVAL 1 HOUR)";
					
		$resultMain = mysql_query($query);
		if ($resultMain) {
		
			while ($row = mysql_fetch_assoc($resultMain)){
				if ($row['user_id']){
					$result = mysql_query("INSERT INTO alert_archive (type, vehicle_points_id, vehicle_id, value, max_value, status, user_id, first_occurrence, last_occurrence)
															values	({$row['type']}, {$row['vehicle_points_id']}, {$row['vehicle_id']}, {$row['value']}, {$row['max_value']}, 3, {$row['user_id']}, '{$row['first_occurrence']}', '{$row['last_occurrence']}')");
				}else{
					$result = mysql_query("INSERT INTO alert_archive (type, vehicle_points_id, vehicle_id, value, max_value, status, user_id, first_occurrence, last_occurrence)
															values	({$row['type']}, {$row['vehicle_points_id']}, {$row['vehicle_id']}, {$row['value']}, {$row['max_value']}, 3, NULL, '{$row['first_occurrence']}', '{$row['last_occurrence']}')");
						
				}
					if (!$result) {
					  die('Invalid query2: ' . mysql_error());
					}
				$result = mysql_query("DELETE FROM alert WHERE id = {$row['id']}");
					if (!$result) {
					  die('Invalid query3: ' . mysql_error());
					}
			}
		}else{
			die('Invalid query1: ' . mysql_error());
		}
		
		


?>
