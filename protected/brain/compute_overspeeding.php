<?php
$config = include("/var/www/html/atgps/protected/config/main.php");
$connection = mysqli_connect($config['params']['dbHost'], $config['components']['db']['username'], $config['components']['db']['password'], $config['components']['db']['username']);

$date = "2026-05-01";
$from = str_replace("-", "", $date) . "000000";
$to = str_replace("-", "", $date) . "235959";

$sql = "SELECT id FROM vehicle LIMIT 10"; // Test with 10 vehicles
$res = mysqli_query($connection, $sql);
while($row = mysqli_fetch_assoc($res)) {
    $vid = $row['id'];
    $table = "vehicle_points_" . $vid;
    $res2 = mysqli_query($connection, "SHOW TABLES LIKE '$table'");
    if(mysqli_num_rows($res2) == 0) continue;

    $sql_points = "SELECT speed, latitude, longitude, gps_datetime FROM $table WHERE gps_datetime BETWEEN '$from' AND '$to' AND speed >= 80 ORDER BY gps_datetime ASC";
    $pts_res = mysqli_query($connection, $sql_points);
    $count = mysqli_num_rows($pts_res);
    if($count > 0) {
        echo "Vehicle $vid has $count speeding points\n";
    }
}
