<?php
$file = '/var/www/html/atgps/protected/controllers/ReportsController.php';
$content = file_get_contents($file);

$new_method = <<<'METHOD'
private function calculateDistance($lat1, $lng1, $lat2, $lng2)
{
$pi80 = M_PI / 180;
$lat1 *= $pi80;
$lng1 *= $pi80;
$lat2 *= $pi80;
$lng2 *= $pi80;
$r = 6372.797; 
$dlat = $lat2 - $lat1;
$dlng = $lng2 - $lng1;
$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
return $r * $c;
}

public function actionOverSpeedingAll()
{
$model = new AlertOverspeed('search');

if(isset($_POST['Vehicle']['date']) && $_POST['Vehicle']['date'])
{
$date = trim($_POST['Vehicle']['date']);
if (strpos($date, '/') !== false) {
$dateParts = explode("/", $date);
$date = trim($dateParts[2])."-".str_pad(trim($dateParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($dateParts[0]), 2, '0', STR_PAD_LEFT);
}

$speedLimit = $_POST['Vehicle']['speedLimit'];
if (!$speedLimit) $speedLimit = 80;

$from = str_replace("-", "", $date) . "000000";
$to = str_replace("-", "", $date) . "235959";

$criteria = new CDbCriteria;
if (Yii::app()->user->level < 1000) {
$criteria->condition = "company_id = " . Yii::app()->user->company_id;
}
$vehicles = Vehicle::model()->findAll($criteria);

$reportData = array();

foreach($vehicles as $v) {
$table = 'vehicle_points_' . $v->id;
if(Yii::app()->db->schema->getTable($table) === null) continue;

$sql = "SELECT speed, latitude, longitude, gps_datetime FROM $table WHERE gps_datetime BETWEEN '$from' AND '$to' AND speed > 0 ORDER BY gps_datetime ASC";
$points = Yii::app()->db->createCommand($sql)->queryAll();

if (count($points) == 0) continue;

$time_one = 0; $dist_one = 0;
$time_two = 0; $dist_two = 0;
$time_three = 0; $dist_three = 0;
$time_four = 0; $dist_four = 0;
$max_speed = 0;

for ($i=1; $i<count($points); $i++) {
$p1 = $points[$i-1];
$p2 = $points[$i];

if ($p2['speed'] > $max_speed) $max_speed = $p2['speed'];

if ($p2['speed'] >= $speedLimit) {
$dist = $this->calculateDistance($p1['latitude'], $p1['longitude'], $p2['latitude'], $p2['longitude']) * 1000;

$d1 = DateTime::createFromFormat('YmdHis', $p1['gps_datetime']);
$d2 = DateTime::createFromFormat('YmdHis', $p2['gps_datetime']);
$time = 0;
if ($d1 && $d2) {
$time = $d2->getTimestamp() - $d1->getTimestamp();
}

if ($time > 3600) $time = 0;

if ($speedLimit == 80) {
if ($p2['speed'] >= 80 && $p2['speed'] < 90) { $time_one += $time; $dist_one += $dist; }
elseif ($p2['speed'] >= 90 && $p2['speed'] < 100) { $time_two += $time; $dist_two += $dist; }
elseif ($p2['speed'] >= 100 && $p2['speed'] < 120) { $time_three += $time; $dist_three += $dist; }
elseif ($p2['speed'] >= 120) { $time_four += $time; $dist_four += $dist; }
} else {
if ($p2['speed'] >= 90 && $p2['speed'] < 100) { $time_one += $time; $dist_one += $dist; }
elseif ($p2['speed'] >= 100 && $p2['speed'] < 120) { $time_two += $time; $dist_two += $dist; }
elseif ($p2['speed'] >= 120) { $time_three += $time; $dist_three += $dist; }
}
}
}

if ($time_one > 0 || $time_two > 0 || $time_three > 0 || $time_four > 0) {
$driverName = 'N/A';
$driverId = null;
$sql_driver = "SELECT d.id, d.name FROM driver d JOIN vehicle_drivers vd ON vd.driver_id = d.id WHERE vd.vehicle_id = " . $v->id . " LIMIT 1";
$d_row = Yii::app()->db->createCommand($sql_driver)->queryRow();
if ($d_row) {
$driverName = $d_row['name'];
$driverId = $d_row['id'];
}

$reportObj = new stdClass();
$reportObj->vehicle = (object)array('attributes' => array('serial' => $v->serial));
$reportObj->driver = (object)array('attributes' => array('name' => $driverName));
$reportObj->attributes = array(
'max_speed' => $max_speed,
'time_one' => $time_one,
'distance_one' => $dist_one,
'time_two' => $time_two,
'distance_two' => $dist_two,
'time_three' => $time_three,
'distance_three' => $dist_three,
'time_four' => $time_four,
'distance_four' => $dist_four,
'vehicle_id' => $v->id,
'driver_id' => $driverId
);
$reportData[] = $reportObj;
}
}

if ($_POST['Vehicle']['groupBy'] == "driver") {
$grouped = array();
foreach($reportData as $row) {
$did = $row->attributes['driver_id'];
if (!$did) continue;
if (!isset($grouped[$did])) {
$grouped[$did] = $row;
} else {
$grouped[$did]->attributes['max_speed'] = max($grouped[$did]->attributes['max_speed'], $row->attributes['max_speed']);
$grouped[$did]->attributes['time_one'] += $row->attributes['time_one'];
$grouped[$did]->attributes['distance_one'] += $row->attributes['distance_one'];
$grouped[$did]->attributes['time_two'] += $row->attributes['time_two'];
$grouped[$did]->attributes['distance_two'] += $row->attributes['distance_two'];
$grouped[$did]->attributes['time_three'] += $row->attributes['time_three'];
$grouped[$did]->attributes['distance_three'] += $row->attributes['distance_three'];
$grouped[$did]->attributes['time_four'] += $row->attributes['time_four'];
$grouped[$did]->attributes['distance_four'] += $row->attributes['distance_four'];
$grouped[$did]->vehicle->attributes['serial'] .= ', ' . $row->vehicle->attributes['serial'];
}
}
$reportData = array_values($grouped);
}

$dataProvider = new CArrayDataProvider($reportData, array(
'pagination' => false,
));
} else {
$dataProvider = new CArrayDataProvider(array(), array('pagination' => false));
}

$this->render('overSpeedingAll',array(
'dataProvider'=>$dataProvider,
'model'=>$model,
));
}
METHOD;

$pattern = '/\tpublic function actionOverSpeedingAll\(\)\s*\{.*?\t\}\s*/s';
$content = preg_replace($pattern, $new_method . "\n", $content);

file_put_contents($file, $content);
echo "Replaced successfully\n";
