<?php
set_time_limit(0);
include("/var/www/html/atgps/cron/initial.php");
$startTime = microtime(true);

$yesterday = date("Ymd");
if ($_GET['date']){
	$yesterday = $_GET['date'];
}


// $begin = new DateTime('2020-06-18');
// $end = new DateTime('2021-06-18');

$yesterday = date("Y-m-d",strtotime("-1 days"));
$today = date("Y-m-d");
$tomorrow = date("Y-m-d",strtotime("1 days"));

$begin = new DateTime($yesterday);
$end = new DateTime($tomorrow);


$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$queryTotal = mysql_query("SELECT id, count(*) as total FROM vehicle");
$resultTotal = mysql_fetch_assoc($queryTotal);
$totalVehicles = $resultTotal['total'];

$i = 0;

		$queryMain = "SELECT id FROM vehicle";
		$resultMain = mysql_query($queryMain);

        if ($resultMain) {

			while ($row = mysql_fetch_assoc($resultMain)){
				$id = $row['id'];
				$i++;
				echo $id."\n";
					foreach ($period as $dt) {
						$date = $dt->format("Y-m-d");
						echo $date." id: ".$id." (".$i."/".$totalVehicles.")"."\n";
						$querySelectDuplicates = 'SELECT id, vehicle_id, odometer, datetime FROM vehicle_odometer_snaps WHERE datetime like "'.$date.'%" and vehicle_id = '.$id.' and id != (SELECT MAX(id) FROM vehicle_odometer_snaps WHERE datetime like "'.$date.'%" and vehicle_id = '.$id.');';
						$resultSelectDuplicates = mysql_query($querySelectDuplicates);
						if ($resultSelectDuplicates){
							while ($rowDuplicates = mysql_fetch_assoc($resultSelectDuplicates)){
								$queryDelete = "DELETE FROM vehicle_odometer_snaps WHERE id = ".$rowDuplicates['id'].";";
								$resultDelete = mysql_query($queryDelete);
								if ($resultDelete){
									echo "Duplicate Record Deleted ".$rowDuplicates['id']." \r\n";
								}
							}
						}
					}	
				echo "__________________________\r\n";
			}
			
			
		}else{
			die('Invalid resultMain: ' . mysql_error());
		}
                

		

$finishTime = microtime(true);

$scriptTime = $finishTime - $startTime;

echo $scriptTime;


function reformDateTime($dateTime){
	$date = DateTime::createFromFormat('YmdHis', $dateTime);
	return($date->format('Y-m-d  H:i:s'));
}
?>
