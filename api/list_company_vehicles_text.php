<?php
require_once('initial.php');

$id = $_GET['id'];
$from = $_GET['from'];
$to = $_GET['to'];
if($from && $to){$where = "AND (dateTime between '$from' AND '$to 23:59:59')";}

                $query = "SELECT t.vehicle_id, v.serial, sum(t.odometer)as dist
                            FROM (SELECT * from vehicle_odometer_snaps UNION SELECT * from vehicle_odometer_snaps_today) as t
                            LEFT JOIN vehicle as v ON v.id = t.vehicle_id
                            WHERE v.company_id=$id $where
                            GROUP BY t.vehicle_id
                            Order By v.serial+0, v.serial+0 <>0 DESC, v.serial";
					
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query2: ' . mysql_error());
		}
		
		
		
		// Iterate through the rows, adding XML nodes for each
		while ($row = mysql_fetch_assoc($result)){
                    echo $row['serial'].",";
                    echo $row['dist']."\r\n";
		}


?>

