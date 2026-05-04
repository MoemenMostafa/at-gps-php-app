<?php
Yii::app()->getClientScript()->registerScriptFile('js/print.js');
Yii::app()->getClientScript()->registerScriptFile('js/dygraph-combined.js');
Yii::app()->getClientScript()->registerScriptFile('js/dygraph-extra.js');

/* @var $dataProvider Reports */
/* @var $this Reports */
/* @var $model Reports */
/* @var $results Reports */

$this->formName = "-vehiclesOdometerDaily";
$this->form= new Vehicle;

$leftAxis = $_POST['leftAxis'];
$rightAxis = $_POST['rightAxis'];
$date = date("h:i:s a d/m/Y");
$distance = Yii::app()->request->getParam('distance');

//if (!$date) goto noData;

//get data array from dataProvider
if ($dataProvider->totalItemCount > 0){
	
//        echo "<button class=\"btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"printContent('vehiclesDistance-grid');\"><i class=\"icon-white icon-print\"></i></button>";
//
//        echo CHtml::link('Export CSV',array('reports/vehiclesDistanceAccumulative&export=true&vehicleId='.$device_id.'&dateRange='.$date),array('class'=>'btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all'));
//        echo CHtml::link('Export As Separate vehicles CSV',array('reports/vehiclesDistanceAccumulative&export_separate_vehicles=true&vehicleId='.$device_id.'&dateRange='.$date),array('class'=>'btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all'));


    $this->widget('zii.widgets.grid.CGridView', array(
           'id' => 'vehiclesDistance-grid',
	   'dataProvider'=>$dataProvider,
	   'summaryText'=>'Vehicles odometer Report < '.$distance.' Km  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; from '.reformDateTime($dateTimeFrom, Yii::app()->user->timezone).' to '.reformDateTime($dateTimeTo , Yii::app()->user->timezone),
            'selectableRows' => 0,
            //'template' => $dialog->link()."{summary}\n{items}\n{pager}",
            'columns' =>
            array(
                array('header'=>'SN.',
                    'value'=>'++$row',
                ),
                "vehicle_number",
                "distance"
            )
            ));

        
?>	


        
        
<?php	
goto End;
noData:
?>
<h1>No data available to display. Please Select another distance.</h1>
<?php
End:
}else{
?>
<h1>No data available to display. Please Select another distance.</h1>

    
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
