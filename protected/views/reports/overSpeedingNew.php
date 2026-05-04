<?php
Yii::app()->getClientScript()->registerScriptFile('js/print.js');

/* @var $dataProvider Reports */
/* @var $this Reports */
/* @var $model Reports */
/* @var $results Reports */


$this->form= new Vehicle;


//get data array from dataProvider
if ($dataProvider->totalItemCount > 0 && $_POST['Vehicle']['id']){
	
	$data = $dataProvider->getData();
			
	$userStopDistance = $_POST['Vehicle']['stopDistance']; //in meters
	$userStopDuration = $_POST['Vehicle']['stopTime']; //in min.
	$legalMaxSpeed1 = $_POST['Vehicle']['speedLimit']; // in Kmph
	$legalMaxSpeed2 = $legalMaxSpeed1+10; // in Kmph
	$legalMaxSpeed3 = $legalMaxSpeed2+20; // in Kmph
	
	$userStopDuration = $userStopDuration *60;

	$startPoint[]= 0;
	for($i=0;$i<count($data);$i++){
				
			$distance[$i] = round(distance($data[$i]->attributes['latitude'],$data[$i]->attributes['longitude'],$data[$i+1]->attributes['latitude'],$data[$i+1]->attributes['longitude'])*1000);
			$tripDistanceChecker += $distance[$i]; // This variable is used to check the distance between startpoint and stoppoint
			$stopSpeeds[$i] = $data[$i]->attributes['speed'];
			
			$ignitionStat = ignitionStatBol($data[$i]->attributes['input_status']);
                        
			if($ignitionStat == 0){
				$stopDistance = NULL;
				$tripDistanceChecker = NULL;
				$l=$i;
				
				/*------------------------------------------------------------------*/
				/* Check if the point is a real stop (the vehicle did't move after  */
				/*	that point for the spacified time and the spacified distance)	*/
				/*------------------------------------------------------------------*/
				while (ignitionStatBol($data[$l]->attributes['input_status']) == 0 && $l< $i+100 &&  $stopDistance < $userStopDistance){
					$stopDistance += round(distance($data[$l]->attributes['latitude'],$data[$l]->attributes['longitude'],$data[$l+1]->attributes['latitude'],$data[$l+1]->attributes['longitude'])*1000);
					if($stopDistance > $userStopDuration){
						break; // It is not a stop
					}	
					$l++;
				}
				if(strtotime($data[$l]->attributes['gps_datetime']) >= strtotime($data[$i]->attributes['gps_datetime']) + $userStopDuration){
						#echo $stopDistance."<br/>\r\n";
						$stopPoint[]= $i;
						$startPoint[]= $l;
						$i=$l;	
				}
				
			}
			
			
		
	}
	
	// Prepare report data array
	
	
	
	
	for ($i=0;$i<count($startPoint)-1;$i++){
		
		$stopDuration[$i] = stopDuration(strtotime($data[$stopPoint[$i]]->attributes['gps_datetime']),strtotime($data[$startPoint[$i+1]]->attributes['gps_datetime']));
		
		if ($i == count($startPoint)-2){$stopDuration[$i] = 0 ; }
		
		$stopDistances[$i]=round((sumDistance($startPoint[$i],$stopPoint[$i],$distance))/1000,1);
		
		if (maxSpeed($startPoint[$i],$stopPoint[$i],$stopSpeeds)>$legalMaxSpeed1){
		
		$reportData[] = array(
						'i'=>$i+1,
						'startDate'=>reformDate($data[$startPoint[$i]]->attributes['gps_datetime'],Yii::app()->user->timezone),
						'to'=>getAddress($data[$stopPoint[$i]]->attributes['latitude'],$data[$stopPoint[$i]]->attributes['longitude']),
						'from'=>getAddress($data[$startPoint[$i]]->attributes['latitude'],$data[$startPoint[$i]]->attributes['longitude']),
						#'from'=>$data[$startPoint[$i]]->attributes['id'],
						'startTime'=>reformTime($data[$startPoint[$i]]->attributes['gps_datetime'],Yii::app()->user->timezone),
						'maxSpeed'=>maxSpeed($startPoint[$i],$stopPoint[$i],$stopSpeeds),
						'maxSpeedDuration1'=>overSpeedDuration($startPoint[$i],$stopPoint[$i],$legalMaxSpeed1, $data,$stopSpeeds),
						'overSpeedDistance1'=>overSpeedDistance($startPoint[$i],$stopPoint[$i],$legalMaxSpeed1, $distance,$stopSpeeds),
						'maxSpeedDuration2'=>overSpeedDuration($startPoint[$i],$stopPoint[$i],$legalMaxSpeed2, $data,$stopSpeeds),
						'overSpeedDistance2'=>overSpeedDistance($startPoint[$i],$stopPoint[$i],$legalMaxSpeed2, $distance,$stopSpeeds),
						'maxSpeedDuration3'=>overSpeedDuration($startPoint[$i],$stopPoint[$i],$legalMaxSpeed3, $data,$stopSpeeds),
						'overSpeedDistance3'=>overSpeedDistance($startPoint[$i],$stopPoint[$i],$legalMaxSpeed3, $distance,$stopSpeeds),
						'stopTime'=>reformTime($data[$stopPoint[$i]]->attributes['gps_datetime'],Yii::app()->user->timezone),
						'stopDuration'=>secToHMS($stopDuration[$i]),
						#'to'=>$data[$stopPoint[$i]]->attributes['id'],
						'driver'=>getDriver($data[$stopPoint[$i]]->attributes['id'])
						);
		}
	}
	if(!isset($reportData)){goto noData ;}
	
	$vehicle = getVehicle($data[0]->attributes['device_id']);
	
	$tripDuration = strtotime($data[$stopPoint[$i-1]]->attributes['gps_datetime']) - strtotime($data[$startPoint[1]]->attributes['gps_datetime']);
	
	$actualDuration = secToHMS($tripDuration - array_sum($stopDuration));
	
	$tripDuration = secToHMS($tripDuration);
	
	
	
	$dataH=array('date'=>$_POST['Vehicle']['dateFrom'].' - '.$_POST['Vehicle']['dateTo'],'no'=>$vehicle['serial'],'tripDuration'=>$tripDuration,'type'=>$vehicle['name'],'actualTripDuration'=>"$actualDuration",'layer1'=>$legalMaxSpeed1,'layer2'=>$legalMaxSpeed2,'layer3'=>$legalMaxSpeed3,'totalDistance'=>round(array_sum($stopDistances)));
	
	
	
	
	#print_r($reportData);
	
	
	// temporary disable Yii autoloader
	spl_autoload_unregister(array('YiiBase','autoload'));
	// create 3rd-party object
	require_once('php_report/PHPReport.php');
	// enable Yii autoloader
	spl_autoload_register(array('YiiBase','autoload'));
	
	
	
	//which template to use
	if(isset($_GET['template']))
		$template=$_GET['template'];
	else
		$template='OverSpeeding.xlsx';
		
	//set absolute path to directory with template files
	$templateDir= substr($_SERVER['SCRIPT_FILENAME'], 0, strlen($_SERVER['SCRIPT_FILENAME']) - strlen(strrchr($_SERVER['SCRIPT_FILENAME'], "/")))."/php_report/templates/";
	
	
	//set config for report
	$config=array(
			'template'=>$template,
			'templateDir'=>$templateDir
		);
	
	$R=new PHPReport($config);
	
	
	$R->load(array(
				array(
						'id'=>'h',
						'repeat'=>false,
						'data'=>$dataH,
	
						
					),
				array(
						'id'=>'v',
						'repeat'=>true,
						'data'=>$reportData,
					)
				)
			);
	

	echo "<button class=\"btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:printContent('sheet0')\"><i class=\"icon-white icon-print\"></i></button>";


	
	echo $R->render('html');
	
goto End;
noData:
?>
<h1>No data available to display. Please Select another vehicle or change time range.</h1>
<?php
End:
}else{
?>
<h1>No data available to display. Please Select another vehicle or change time range.</h1>
<?php
}
	
	
	
	
	function distance($lat1, $lng1, $lat2, $lng2, $miles = false)
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
	
	function sumDistance($pointA,$pointB,$distance=array()){
		for($d=$pointA;$d<=$pointB;$d++){
				$tripDistance += $distance[$d];
				
		}
		return $tripDistance;
	};
	
	function maxSpeed($pointA,$pointB,$stopSpeeds=array()){
		for($d=$pointA;$d<=$pointB;$d++){
				if ($stopSpeeds[$d]>$maxSpeed){$maxSpeed=$stopSpeeds[$d];}
				
		}
		return $maxSpeed;
	};
	
	function overSpeedDuration($pointA,$pointB,$legalMaxSpeed, $data=array(),$stopSpeeds=array()){
		$overSpeedDuration = NULL;
		for($d=$pointA;$d<=$pointB;$d++){
				if ($stopSpeeds[$d]>$legalMaxSpeed){$overSpeedDuration += stopDuration(strtotime($data[($d)]->attributes['gps_datetime']),strtotime($data[$d+1]->attributes['gps_datetime']));}
		}
		
		return secToHMS($overSpeedDuration);
	};
	
	function overSpeedDistance($pointA,$pointB,$legalMaxSpeed, $distance=array(),$stopSpeeds=array()){
		$overSpeedDistance = NULL;
		for($d=$pointA;$d<=$pointB;$d++){
				if ($stopSpeeds[$d]>$legalMaxSpeed){$overSpeedDistance += $distance[$d];}
				
		}
		return round($overSpeedDistance/1000,1);
	};
	
	function stopDuration($timeA,$timeB){
	
		$stopDuration = $timeB - $timeA; // in seconds
	
		return $stopDuration;	
	};
	
	function getDriver($id){
	$vehicleId = (int)$_POST['Vehicle']['id'];
	$driver = Yii::app()->db->createCommand()
		->select('d.name')
		->from('driver d')
		->join('vehicle_drivers vd', 'vd.driver_id = d.id')
		->where('vd.vehicle_id=:v_id', array(':v_id'=>$vehicleId))
		->queryRow();
		return $driver['name'];
	};
	
	function getVehicle($dummy){
	$vehicleId = (int)$_POST['Vehicle']['id'];
	$vehicle = Yii::app()->db->createCommand()
		->select('name, serial')
		->from('vehicle')
		->where('id=:id', array(':id'=>$vehicleId))
		->queryRow();
		return $vehicle;
	};
	
	
	
	function secToHMS($sec) {
		$s = $sec % 60;
		$sec= floor($sec/60);
	
		$m = $sec % 60;
		$sec= floor($sec/60);
	
		$h = floor($sec);
			
		if ($s<10)
			$s = "0$s";
		if ($m<10)
			$m = "0$m";
		if ($h<10)
			$h = "0$h";
	
		$str = "$h:$m:$s";
	
		return $str;
	
	}


?>
