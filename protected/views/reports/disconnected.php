<?php
Yii::app()->getClientScript()->registerScriptFile('js/print.js');

/* @var $dataProvider Reports */
/* @var $this Reports */
/* @var $model Reports */
/* @var $results Reports */

$this->formName = "-disconnected";
$this->form= new Vehicle;
/*
$dateRange = explode(" - ",$_POST['Vehicle']['dateRange']);
$from = $dateRange[0];
$to= $dateRange[1];
*/
$date = $_POST['LastConnection']['date'];
if ($_POST['Vehicle']['groupBy'] == "driver"){
	$driver = "-driver";
}

$now = date("d/m/Y h:i a");

$userData = $this->userData;
$model=new LatestPoints('search');
$company_id=Yii::app()->user->company_id;
$value = Company::Model()->findByAttributes(array('id'=>$company_id));
$threshold = $value['attributes'];


		
	echo "<button class=\"btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:printContent('disconnected-grid','Disconnected Vehicles Report')\"><i class=\"icon-white icon-print\"></i></button>";


	$table = $this->widget('zii.widgets.grid.CGridView', array(
           'id' => 'disconnected-grid',
	   'dataProvider'=>$dataProvider,
	   'summaryText'=>'Disconnected Vehicles Report &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$now,
            'selectableRows' => 0,
            //'template' => $dialog->link()."{summary}\n{items}\n{pager}",
            'columns' => array(
				array('header'=>'SN.',
					  'value'=>'++$row',
				),
				array(
					"header" => "",
					"type" => "raw",
					'value' => 'CHtml::tag("div",getStatus($data->gps_datetime, $data->last_connection, "GMT",getRepairStatus($data->vehicle->id)),"")',

				),

				'vehicle.serial',
			    
				array(
					"name" => "address",

				),

			   
			   	array(
					"name" => 'speed',

				),
			    array(
                                        "name" => 'date',
					"header" => "Latest Update D",
			   		'value'=>'reformDate($data->gps_datetime, Yii::app()->user->timezone)',

				),
                
                            array(
					"header" => "Latest Update T",
			   		'value'=>'reformTime($data->gps_datetime, Yii::app()->user->timezone)',

				),


				array(
					"header" => "Ignition",
			   		"type" => "raw",
					'value'=>'ignitionStat($data->input_status)',

				),
		
            )
            )
);
        



function checkAlert($value, $threshold){
    
   If ($value > $threshold){
        echo "<span style='color:red'>".$value."</span>";
        //echo "<span style='color:red'>".$value."</span>";
    }else{
        echo "<span>".$value."</span>";
    }

}


?>