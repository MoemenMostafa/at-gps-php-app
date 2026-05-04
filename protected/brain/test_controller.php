<?php
$_SERVER['REQUEST_URI'] = "/index.php?r=reports/overSpeedingAll";
$_POST['Vehicle'] = array(
    'date' => '2026-05-01',
    'speedLimit' => '80',
    'groupBy' => 'vehicle'
);
$config = include('/var/www/html/atgps/protected/config/main.php');
// Needs proper Yii bootstrap. Actually, better test it using curl?
// Wait, I need login to use curl.
