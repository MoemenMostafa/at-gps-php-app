
<?php
Yii::app()->getClientScript()->registerScriptFile('js/print.js');
/* @var $dataProvider Reports */
/* @var $this Reports */
/* @var $model Reports */
/* @var $results Reports */


$this->form= new Vehicle;

//Create Map
$gMap = new EGMap();
$gMap->zoom = 6;

$polylines = array();



//get data array from dataProvider
if ($dataProvider->totalItemCount > 1 && $_POST['Vehicle']['id']){
	
	$data = $dataProvider->getData();
			
	$userStopDistance = $_POST['Vehicle']['stopDistance']; //in meters
	$userStopDuration = $_POST['Vehicle']['stopTime']; //in min.
	$legalMaxSpeed = $_POST['Vehicle']['speedLimit']; // in Kmph
	
	$userStopDuration = $userStopDuration *60;

	$startPoint[]= 0;
	$countData = count($data);
	
			echo "<script>
					var data = [];
					for(var x = 0; x < $countData; x++){
						data[x] = [];    
					}
				  </script>";
	
	for ($i=0;$i<$countData;$i++){
			//$js_date = date("Y-m-d h:i:s a",strtotime($data[$i]->attributes['gps_datetime']));
			$js_date = reformDateTime($data[$i]->attributes['gps_datetime']);
			$jsData[$i]['latitude'] = $data[$i]->attributes['latitude'];
			$jsData[$i]['longitude'] = $data[$i]->attributes['longitude'];
			$jsData[$i]['speed'] = $data[$i]->attributes['speed'];
			$jsData[$i]['direction'] =$data[$i]->attributes['direction'];
			$jsData[$i]['gps_datetime'] = $js_date;	
	}
	for($i=0;$i<$countData;$i++){
				
			$distance[$i] = round(distance($data[$i]->attributes['latitude'],$data[$i]->attributes['longitude'],$data[$i+1]->attributes['latitude'],$data[$i+1]->attributes['longitude'])*1000);
			$tripDistanceChecker += $distance[$i]; // This variable is used to check the distance between startpoint and stoppoint
			$stopSpeeds[$i] = $data[$i]->attributes['speed'];
			
			// Set the coordinates to draw path on map
			$coords[] = new EGMapCoord($data[$i]->attributes['latitude'], $data[$i]->attributes['longitude']);
			
			
			/*-- Get all the points with that is after user specified distance and below 5 Km speed --*/
			if($tripDistanceChecker > $userStopDistance  && $data[$i]->attributes['speed'] < 5){
				$stopDistance = NULL;
				$tripDistanceChecker = NULL;
				$l=$i;
				
				/*-------------------------------------------------------------------*/
				/* Check if the point is a real stop (the vehicle didn't move after  */
				/*	that point for the spacified time and the spacified distance)	 */
				/*-------------------------------------------------------------------*/
				while (strtotime($data[$l]->attributes['gps_datetime']) < (strtotime($data[$i]->attributes['gps_datetime']) + $userStopDuration) && $stopDistance < $userStopDistance){
					$stopDistance += round(distance($data[$l]->attributes['latitude'],$data[$l]->attributes['longitude'],$data[$l+1]->attributes['latitude'],$data[$l+1]->attributes['longitude'])*1000);
					if($stopDistance > $userStopDistance){
						break; // It is not a stop
					$stopDistance += round(distance($data[$l]->attributes['latitude'],$data[$l]->attributes['longitude'],$data[$l+1]->attributes['latitude'],$data[$l+1]->attributes['longitude'])*1000);
					}	
					$l++;
				}

				if(strtotime($data[$l]->attributes['gps_datetime']) >= strtotime($data[$i]->attributes['gps_datetime']) + $userStopDuration){
						$stopDistancePoint[$i] = $stopDistance;
						$stopPoint[]= $i;
						$startPoint[]= $l;
	
						
						
						$i=$l;	
				}
				
			}
			
			
		$counterEnd = $i;
		
	}
	
	// Set the last retrived point as last stop point.
		$stopPoint[]= $countData-2;
	// Prepare report data array
	
	
	
	
	for ($i=0;$i<count($startPoint);$i++){
		$stopDuration;
		if ($i < count($startPoint)-1){
			$stopDuration[$i] = stopDuration(strtotime($data[$stopPoint[$i]]->attributes['gps_datetime']),strtotime($data[$startPoint[$i+1]]->attributes['gps_datetime']));
		}
		
		$stopDistances[$i]=round((sumDistance($startPoint[$i],$stopPoint[$i],$distance))/1000,1);
		
		
		
		$reportData[] = array(
						'startDate'=>reformDate($data[$startPoint[$i]]->attributes['gps_datetime'],Yii::app()->user->timezone),
						'startTime'=>reformTime($data[$startPoint[$i]]->attributes['gps_datetime'],Yii::app()->user->timezone),
						'to'=>getAddress($data[$stopPoint[$i]]->attributes['latitude'],$data[$stopPoint[$i]]->attributes['longitude']),
						'from'=>getAddress($data[$startPoint[$i]]->attributes['latitude'],$data[$startPoint[$i]]->attributes['longitude']),
						#'from'=>$data[$startPoint[$i]]->attributes['id'],
						#'to'=>$data[$stopPoint[$i]]->attributes['id'],
						'stopTime'=>reformTime($data[$stopPoint[$i]]->attributes['gps_datetime'],Yii::app()->user->timezone),
						'travelingDistance'=>$stopDistances[$i],
						'maxSpeed'=>maxSpeed($startPoint[$i],$stopPoint[$i],$stopSpeeds),
						'overSpeedDistance'=>overSpeedDistance($startPoint[$i],$stopPoint[$i],$legalMaxSpeed, $distance,$stopSpeeds),
						'stopDuration'=>secToHMS($stopDuration[$i]),
						'driver'=>getDriver($data[$stopPoint[$i]]->attributes['id'])
						);

						
	}
	$x=0;
	if(!isset($stopPoint)){goto noData ;}
	foreach($stopPoint as $point){
		// Create Map Stop markers
		$x++;
		$marker = new EGMapMarker($data[$point]->attributes['latitude'], $data[$point]->attributes['longitude'], array('title' => "stop, Direction: {$data[$point]->attributes['direction']}",'icon' => "'images/icons/markerIcons/smallSQRedIcons/marker$x.png'"));
		
		$gMap->addMarker($marker);
		
	}
	// Create Map 1 Start marker

		$marker = new EGMapMarker($data[$startPoint[0]]->attributes['latitude'], $data[$startPoint[0]]->attributes['longitude'], array('title' => "start",'icon' => "'images/icons/markerIcons/largeTDGreenIcons/dd-start.png'"));
		
		$gMap->addMarker($marker);

	/*$x=0;
	foreach($startPoint as $point){
			// Create Map Start markers
		$x++;
		$marker = new EGMapMarker($data[$point]->attributes['latitude'], $data[$point]->attributes['longitude'], array('title' => "start "."$x"));
		
		$gMap->addMarker($marker);
		
	}*/
	
	
	$vehicle = getVehicle($data[0]->attributes['device_id']);
	
	$tripDuration = strtotime($data[$counterEnd]->attributes['gps_datetime']) - strtotime($data[0]->attributes['gps_datetime']);
	
	//$actualDuration = secToHMS($tripDuration - array_sum($stopDuration));
	
	$tripDuration = secToHMS($tripDuration);
	
	
	
	$dataH=array('no'=>$vehicle['serial'],'tripDuration'=>$tripDuration,'type'=>$vehicle['name'],'actualTripDuration'=>"",'maxSpeed'=>$legalMaxSpeed,'totalDistance'=>round(array_sum($stopDistances)));
	
	
	
	
	#print_r($reportData);
	
	
	// temporary disable Yii autoloader
	spl_autoload_unregister(array('YiiBase','autoload'));
	// create 3rd-party object
	require_once('php_report/PHPReport.php');
	// enable Yii autoloader
	spl_autoload_register(array('YiiBase','autoload'));
	
	
	;
	
	
	//which template to use
	if(isset($_GET['template']))
		$template=$_GET['template'];
	else
		$template='abbreviated.xlsx';
		
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
	echo "<button class=\"btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:goto('#start')\"><i class=\"icon-white icon-road\"></i></button>";

	


	
	echo $R->render('html');
	



// Convert coordinates to polylines
$polylines = new EGMapPolyline($coords);


//adding the polylines
$gMap->addPolyline($polylines);
$gMap->centerOnPolylines();
$gMap->zoomOnPolylines(0.1);
$gMap->setWidth('100%');
?>
<!-- Player -->
<div>
<input id="start" type="button" value="start"/>
<input id="stop" type="button" value="stop"/>
PlayBack Speed: 
<select type="number" id="speed">
<option value="1000">1</option>
<option value="700">2</option>
<option value="500" selected="selected">3</option>
<option value="300">4</option>
<option value="100">5</option>
<option value="50">6</option>
<option value="10">7</option>
</select>
<input type="hidden" id="point" />
<?php
$this->widget('zii.widgets.jui.CJuiSlider', array(
	'value'=>$speedLimit,
	'id'=>"pointSlider",
	'options'=>array(
		'step'=>1,
		'max'=>count($data),
		'slide'=>'js:function(event, ui) {pointSlider(event, ui); }',
	),
));


echo "<script> data = ".json_encode($jsData)."</script>";

?>


<script>
var timer = null, 
    interval = document.getElementById('speed').value,
    i = 0;

function pointSlider(event, ui){
		if (ui.value == $("#pointSlider").slider("option", "max")){$("#stop").trigger('click');};
		$("#point").val(ui.value);
		i=ui.value;
		markerManagerPlayer(data[i]['latitude'],data[i]['longitude'],data[i]['direction'],data[i]['gps_datetime'],data[i]['speed']);
}

$("#start").click(function() {
  if (timer !== null) return;
  timer = setInterval(function () {
	  markerManagerPlayer(data[i]['latitude'],data[i]['longitude'],data[i]['direction'],data[i]['gps_datetime'],data[i]['speed']);
	  i = i+1;
      $("#point").val(i);
	  $("#pointSlider").slider("value",i);
  }, interval); 
});

$("#stop").click(function() {
  clearInterval(timer);
  timer = null
});

$("#point").change(function() {
	i = parseInt(this.value);
	markerManagerPlayer(data[i]['latitude'],data[i]['longitude'],data[i]['direction'],data[i]['gps_datetime'],data[i]['speed']);

});

$("#speed").change(function() {
	interval = parseInt(this.value);
	$("#stop").trigger('click');
	$("#start").trigger('click');
});

var check = false;

window.onload = function() {
	// load markers
	markerManagerPlayer(data[0]['latitude'],data[0]['longitude'],data[0]['direction'],data[0]['gps_datetime'],data[0]['speed']);
	// Center the map to all markers bound center after 3 s
	//setTimeout(showAllMarkers,3000);
};

function goto(element){
	window.location = element;	
}

function markerManagerPlayer(lat,long,direction,datetime,speed) {
  
  if (check!=true){
		xml = data.responseXML;
		var markers = [];
		markers['longitude']=long;
		markers['latitude']=lat;
		markers['direction']=direction;
		markers['datetime']=datetime;
		markers['speed']=speed;
		//markers['address']=address;
		var marker;
		infowindow = new Array();
		playerMarker = addMarkerPlayer(EGMap0, markers);
		//bounds.extend(myMarkers[markers[i].getAttribute("device_id")].getPosition());

		
		
 
	
	check = true;
	console.log(check);
  }else{updateMarkersPlayer(lat,long,direction,datetime,speed);}

}

function addMarkerPlayer(map, data) {
	//create the markers
	  var point = new google.maps.LatLng(
		  parseFloat(data['latitude']),
		  parseFloat(data['longitude']));
	  var direction = data['direction'];
	  var directionMod = directionModified(direction);
	  var image = getIcon(directionMod);
	  
	  var playerMarker = new google.maps.Marker({
		map: map,
		position: point,
		//icon: 'http://www.google.com/mapfiles/arrow.png'
		icon: image,
	  });
		//create the info windows
		var content = document.createElement("DIV");
		var title = document.createElement("DIV");
		title.innerHTML = infoWindowContent(data);
		content.appendChild(title);
	   
	   infowindow = new google.maps.InfoWindow({
			content: content
		});
	
		// Open the infowindow on marker click
		google.maps.event.addListener(playerMarker, "click", function() {
			infowindow.open(map, playerMarker);
		});
		return playerMarker;    
}



function updateMarkersPlayer(lat,long,direction,datetime,speed) {
		var markers = [];
		markers['longitude']=long;
		markers['latitude']=lat;
		markers['direction']=direction;
		markers['datetime']=datetime;
		markers['speed']=speed;
		//markers['address']=address;


		changeMarkerPosition(playerMarker, lat, long, direction);
		infowindow.setContent(
					infoWindowContent(markers)
				)		
		//if (setFocusOnRID){focusWithoutZoom(setFocusOnRID);}
		//if (traceMarkerId){setMarkerTrace(traceMarkerId);}
  
  
}
function infoWindowContent(data){
	
		  
	//var vehicle_number = vehicleNumber(data);
	
	return 	"<table><tr><td>Date & Time: </td><td>"+data['datetime']		+"</td></tr>"+
			"<tr><td>Speed: </td><td>"+data['speed']+" Km/h</td></tr>"+
			//"<tr><td>Address: </td><td>"+data["address"]+"</td></tr>"+
			//"<tr><td>Driver: </td><td>"+data.getAttribute("driver_name")+
			"</table>"
			;
							
	
}


function changeMarkerPosition(marker,lat,long,direction) {
	<!--var latlng = new google.maps.LatLng(lat, long);-->
	console.log(marker);
	marker.setPosition(new google.maps.LatLng(lat,long));
	var directionMod = directionModified(direction);
	marker.setIcon(getIcon(directionMod));
	
}

function directionModified(direction){
		var	directionMod = Math.round(direction/10)+1;
	  if (directionMod >= 37) directionMod = 1;	
	  return directionMod;
	
}

function getIcon(directionMod){
	icon = new google.maps.MarkerImage('images/car/blue/Blue_car_'+directionMod+'.png',
        new google.maps.Size(42, 42),
        new google.maps.Point(0,0),
        new google.maps.Point(21, 21)
	  );	
	  return icon;
}




</script>
















<?php
$gMap->renderMap();
?>
</div>
<?php

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
