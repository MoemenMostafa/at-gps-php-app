<?php
Yii::app()->getClientScript()->registerScriptFile('js/print.js');

/* @var $dataProvider Reports */
/* @var $this Reports */
/* @var $model Reports */
/* @var $results Reports */

$this->formName = "-overSpeedingAll";
$this->form= new Vehicle;
/*
$dateRange = explode(" - ",$_POST['Vehicle']['dateRange']);
$from = $dateRange[0];
$to= $dateRange[1];
*/
$date = $_POST['Vehicle']['date'];
$speedLimit = $_POST['Vehicle']['speedLimit'];
if ($_POST['Vehicle']['groupBy'] == "driver"){
	$driver = "-driver";
}

$layer1 = $speedLimit;
$layer2 = $layer1+10;
$layer3 = $layer2+10;
if ($layer3==110){$layer3=120;}
if ($layer1 == 80){$first="one";$second="two";$third="three";}
if ($layer1 == 90){$first="two";$second="three";$third="four";}

//get data array from dataProvider
		
if ($dataProvider->totalItemCount > 0){
	
	$data = $dataProvider->getData();

	$vehicle = array();

	for($i=0;$i<count($data);$i++){
		
		if ($layer1 == 80){
			$maxSpeedDurationThree = $data[$i]->attributes["time_$third"]+ $data[$i]->attributes["time_four"];
			$maxSpeedDistanceThree = $data[$i]->attributes["distance_$third"]+ $data[$i]->attributes["distance_four"];
		}
		if ($layer1 == 90){
			$maxSpeedDurationThree = $data[$i]->attributes["time_$third"];
			$maxSpeedDistanceThree = $data[$i]->attributes["distance_$third"];
		}

				$reportData[] = array(
						'vehicle'=>($data[$i]->vehicle) ? $data[$i]->vehicle->attributes['serial'] : 'N/A',
						'driver'=>($data[$i]->driver) ? $data[$i]->driver->attributes['name'] : 'N/A',
						'maxSpeed'=>$data[$i]->attributes['max_speed'],
						'maxSpeedDuration1'=>secToHMS($data[$i]->attributes["time_$first"]),
						'overSpeedDistance1'=>round($data[$i]->attributes["distance_$first"],1),
						'maxSpeedDuration2'=>secToHMS($data[$i]->attributes["time_$second"]),
						'overSpeedDistance2'=>round($data[$i]->attributes["distance_$second"],1),
						'maxSpeedDuration3'=>secToHMS($maxSpeedDurationThree),
						'overSpeedDistance3'=>round($maxSpeedDistanceThree,1),
						'totalViolationDistance'=>round($data[$i]->attributes["distance_$first"]+$data[$i]->attributes["distance_$second"]+$maxSpeedDistanceThree,1),
						'totalViolationDuration'=>secToHMS($data[$i]->attributes["time_$first"]+$data[$i]->attributes["time_$second"]+$maxSpeedDurationThree),
						'totalDistance'=>"Comming Soon",
						);
			

			
		
	}
	
	aasort($reportData,"maxSpeed");
	$x=0;
	foreach ($reportData as $key => $value){
		$x++;
		$reportData[$key]['i']=$x;
	}
	
	//$dataH=array('startDate'=>$from,'endDate'=>$to, 'layer1'=>"90", "layer2"=>"100", "layer3"=>"120");
	$dataH=array('date'=>$date, 'layer1'=>$layer1, "layer2"=>$layer2, "layer3"=>$layer3);
	
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
		$template="OverSpeedingAll$driver.xlsx";
		
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
<h1>No data available to display. Please Select another vehicle or change time range.1</h1>
<?php
End:
}else{
?>
<h1>No data available to display. Please Select another date.</h1>
<?php
}


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


	function aasort (&$array, $key, $direction = "DESC") {
		$sorter=array();
		$ret=array();
		reset($array);
		foreach ($array as $ii => $va) {
			$sorter[$ii]=$va[$key];
		}
		if ($direction == "DESC"){
		arsort($sorter);
		}	
		if ($direction == "ASC"){
		asort($sorter);
		}
		
		foreach ($sorter as $ii => $va) {
			$ret[$ii]=$array[$ii];
		}
		$array=$ret;
	}

?>
