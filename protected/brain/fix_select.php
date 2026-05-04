<?php
$file = '/var/www/html/atgps/protected/controllers/ReportsController.php';
$content = file_get_contents($file);

$target = "group_concat(vehicle_id separator ',') as vehicle_id, driver_id, max(max_speed) as max_speed, sum(distance_one) as distance_one, sum(time_one) as time_one, sum(distance_two) as distance_two, sum(time_two) as time_two, sum(distance_three) as distance_three, sum(time_three) as time_three";
$replacement = "group_concat(vehicle_id separator ',') as vehicle_id, driver_id, max(max_speed) as max_speed, sum(distance_one) as distance_one, sum(time_one) as time_one, sum(distance_two) as distance_two, sum(time_two) as time_two, sum(distance_three) as distance_three, sum(time_three) as time_three, sum(distance_four) as distance_four, sum(time_four) as time_four";

$newContent = str_replace($target, $replacement, $content);

file_put_contents($file, $newContent);
?>
