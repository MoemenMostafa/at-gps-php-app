<?php
require_once('initial.php');

$id = $_GET['id'];
$vehicle_id = $_GET['vehicle_id'];
$TO = $_GET['to'];
if (!$_GET['zone']){
    $zone = "Etc/GMT+2";
}else{
    $zone = $_GET['zone'];
}
$fromUTC = "20130101000000";
$toUTC = setTimeZone($TO,$zone);
$toUTCsub = setTimeZone($TO,$zone,1,"Ymd235959");

if($vehicle_id && $fromUTC && $toUTC){
    $where = "AND (dateTime between '$fromUTC' AND '$toUTCsub')";


    $query = "SELECT t.vehicle_id, v.serial, sum(t.odometer)as dist
                                FROM (SELECT * from vehicle_odometer_snaps UNION SELECT * from vehicle_odometer_snaps_today) as t
                                LEFT JOIN vehicle as v ON v.id = t.vehicle_id
                                WHERE t.vehicle_id = $vehicle_id $where
                                GROUP BY t.vehicle_id
                                Order By v.serial+0, v.serial+0 <>0 DESC, v.serial";
    $result = mysql_query($query);
    if (!$result) {
        die('Invalid query2: ' . mysql_error());
    }

    // Iterate through the rows, adding XML nodes for each
    while ($row = mysql_fetch_assoc($result)){
        $distance1 = $row['dist'];
    }

    $query = "Select latitude, longitude, gps_datetime FROM vehicle_points_".$vehicle_id." WHERE gps_datetime between '$toUTCsub' and '$toUTC' AND gps_datetime NOT LIKE '20______000000'";

    $records = mysql_query($query);

}

if ($records) {

    while ($record = mysql_fetch_assoc($records)) {
        if (!$prevLat[$vehicle_id]) {
            $distance[$vehicle_id] = 0;
            $prevLat[$vehicle_id] = $record['latitude'];
            $prevLong[$vehicle_id] = $record['longitude'];
        } else {
            $dist = calculateDistance($record['latitude'], $record['longitude'], $prevLat[$vehicle_id], $prevLong[$vehicle_id]);
            $distance[$vehicle_id] += $dist;
            //$gpsDateTime = reformDateTime($record['gps_datetime'],"Etc/GMT+2");
            $prevLat[$vehicle_id] = $record['latitude'];
            $prevLong[$vehicle_id] = $record['longitude'];
        }
    }
}else{
    die('Invalid query: ' . mysql_error());
}

		

        //echo $vehicle_id.",";
        $totalDistance = $distance1 + $distance[$vehicle_id];
        echo round($totalDistance,3);


function calculateDistance($lat1, $lng1, $lat2, $lng2, $miles = false)
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

function setTimeZone($time,$zone,$offset=0,$format="YmdHis"){
    $schedule_date = DateTime::createFromFormat('YmdHis', $time);
    if (!$schedule_date) {
        $schedule_date = new DateTime($time, new DateTimeZone('UTC'));
    }
    $schedule_date->setTimeZone(new DateTimeZone($zone));
    if ($offset > 0) {
        $schedule_date->sub(new DateInterval("P".$offset."D"));
    }
    $timeAdjusted =  $schedule_date->format($format);

    return $timeAdjusted;
}


?>

