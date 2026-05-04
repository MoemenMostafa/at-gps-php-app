<?php
Yii::app()->getClientScript()->registerScriptFile('js/print.js');
Yii::app()->getClientScript()->registerScriptFile('js/dygraph-combined.js');
Yii::app()->getClientScript()->registerScriptFile('js/dygraph-extra.js');

/* @var $dataProvider Reports */
/* @var $this Reports */
/* @var $model Reports */
/* @var $results Reports */

$this->formName = "-driver";
$this->form= new Driver;

$leftAxis = $_POST['leftAxis'];
$rightAxis = $_POST['rightAxis'];
$date = $_POST['Vehicle']['dateRange'];
$device_id = $_POST['Vehicle']['id'];

if (!$date) goto noData;

//get data array from dataProvider
if ($dataProvider->totalItemCount > 0){
	

        //$data = $dataProvider->getData();
	
        //print_r($data);
                //echo $array;
        echo "<button class=\"btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"printContent('vehiclesDistance-grid');\"><i class=\"icon-white icon-print\"></i></button>";
        //echo "<button class=\"btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"printContent('vehiclesDistance-grid');\"><i class=\"icon-white icon-print\"></i></button>";

        echo CHtml::link('Export CSV',array('reports/vehicleSpeedZone&export=true&vehicleId='.$device_id.'&dateRange='.$date),array('class'=>'btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all'));


        
       $this->widget('zii.widgets.grid.CGridView', array(
           'id' => 'vehiclesDistance-grid',
	   'dataProvider'=>$dataProvider,
	   'summaryText'=>'Drivers Speed Zones Report &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$_POST['Vehicle']['dateRange'],
            'selectableRows' => 0,
            //'template' => $dialog->link()."{summary}\n{items}\n{pager}",
            'columns' => array(
				array('header'=>'SN.',
					  'value'=>'++$row',
				),
				array(

					"header" => "Date",
					'value'=>'$data->date',

				),

				array(

					"header" => "Driver",
					'value'=>'$data->driver_name',

				),

				array(

					"header" => "Vehicle",
			   		'value'=>'$data->serial',

				),

//				array(
//
//					"header" => "Driver",
//			   		'value'=>'getDriver($data->vehicle_id,$data->datetime)',
//
//				),



				array(

					"header" => "Zone",
					'value'=>'$data->speed_zone_name',

				),

//				array(
//
//					"header" => "Start",
//					'value'=>'$data->start',
//
//				),
//
//				array(
//
//					"header" => "End",
//					'value'=>'$data->end',
//
//				),

				array(

					"header" => "Distance",
			   		'value'=>'$data->odometer',

				),

				array(

					"header" => "Max Speed",
					'value'=>'$data->max_speed',

				),
                


		
                            )
            ));

        
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

function getDriver($vehicle_id,$datetime){
	$driver = Yii::app()->db->createCommand("
		select d.name from trip
		LEFT JOIN driver as d ON d.id = trip.driver_id
		where trip.vehicle_id = $vehicle_id AND '$datetime' between trip.from and trip.to
		")
//		->select('d.name')
//		->from('trip')
//		->where('vehicle_id=:id', array(':id'=>$vehicle_id))
//		->leftJoin("driver as d", "d.id = trip.driver_id")
//		->andWhere('trip.from<=:datetime', array(':datetime'=>$datetime))
//		//->where('trip.to>=:datetime', array(':datetime'=>$datetime))
		->queryRow();
	return $driver['name'];
};


        
function getDistanceKm($end, $start){
        return round((($end-$start)), 0, PHP_ROUND_HALF_UP)." Km";
        
};
	
?>
