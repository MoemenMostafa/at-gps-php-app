<?php
Yii::app()->getClientScript()->registerScriptFile('js/print.js');
Yii::app()->getClientScript()->registerScriptFile('js/dygraph-combined.js');
Yii::app()->getClientScript()->registerScriptFile('js/dygraph-extra.js');

/* @var $dataProvider Reports */
/* @var $this Reports */
/* @var $model Reports */
/* @var $results Reports */

$this->formName = "-vehicleDistance";
$this->form= new Vehicle;

$leftAxis = $_POST['leftAxis'];
$rightAxis = $_POST['rightAxis'];
$dateFrom = $_POST['Vehicle']['from'];
$dateTo = $_POST['Vehicle']['to'];
$device_id = $_POST['Vehicle']['id'];

if (!$dateFrom OR !$dateTo) goto noData;

//get data array from dataProvider
if ($distance > 0){

       # echo "<button class=\"btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"printContent('vehiclesDistance-grid');\"><i class=\"icon-white icon-print\"></i></button>";


    echo "<h1>Distance = ".round($distance,3)." Km</h1>";
    echo "<h2>Odometer Start = ".round($odometerFrom,3)." Km</h2>";
    echo "<h2>Odometer End = ".round($odometerTo,3)." Km</h2>";


?>	


        
        
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

	
function getVehicle($vehicle_id){
	$vehicle = Yii::app()->db->createCommand()
		->select('serial')
		->from('vehicle')
		->where('id=:id', array(':id'=>$vehicle_id))
		->queryRow();
		return $vehicle['serial'];
};
        
function getDistanceKm($end, $start){
        return round((($end-$start)), 0, PHP_ROUND_HALF_UP)." Km";
        
};
	
?>
