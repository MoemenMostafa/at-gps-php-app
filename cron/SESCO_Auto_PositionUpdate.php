<?php

include('initial.php');

$lastConnection = date('Y-m-d H:i:s', time()- (60*5)); // - 5 min from now (connected)
$before = date('YmdHis', time()- (60*60*6)); // -6 hours from now
$today = date("d-m-y");
$log = '/var/log/gps/cron/SESCO_Auto_Position.log';

echo $before."\n"; 
echo $lastConnection."\n";


$query = "SELECT lp.device_id, d.device_type_id, dc.id as commandId FROM `latest_points` as lp
			LEFT JOIN vehicle as v on lp.device_id = v.device_id
			LEFT JOIN device as d on d.id = lp.device_id
			LEFT JOIN device_commands as dc on dc.device_type_id = d.device_type_id
			WHERE lp.gps_datetime < $before AND lp.last_connection > '$lastConnection' AND v.company_id = 3 AND dc.name = 'Get Position'";
					
// AND lp.last_connection > '$lastConnection' AND v.company_id = 3"
		$resultMain = mysql_query($query);
		if ($resultMain) {
			while ($row = mysql_fetch_assoc($resultMain)){
				
				mysql_query("INSERT INTO commands (device_commands_id, device_id) VALUES (".$row['commandId'].", ".$row['device_id'].")");
					
					file_put_contents($log, date("d/m/y h:i:s a").": "."Command [Get Position] recorded for DeviceID:  ".$row['device_id']." CommandID: ".$row['commandId']."\n", FILE_APPEND);
					echo "Command [Get Position] recorded for DeviceID:  ".$row['device_id']." CommandID: ".$row['commandId']."\n";
			}
		}
?>