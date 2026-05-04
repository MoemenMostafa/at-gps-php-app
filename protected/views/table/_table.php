<style>
#status-grid table thead tr{
	position: fixed;
	margin-top: -63px;
	z-index: 1;
}
#status-grid table thead tr th, #status-grid table tbody tr td{
	padding:0px 2px;
}
#status-grid{
	padding: 86px 0px;
}
#status-grid table tbody{
	position:absolute;
}


#status-grid .ecolumns-link{
	z-index: 9;
	position: fixed;
	margin-top: -87px;
	border: 1px solid lightgray;
	background-color: orange;
	color: white;
	padding: 4px 0px 5px 20px;
	width: 50px;
}
.filterLink {
	margin: 2px 10px 2px 2px;
	text-decoration: none;
	color: black;
}
.grid-view table.items {
	border: none !important;
</style>

<?php
/***********************/
/** Table Starts here **/
/***********************/
$userData = $this->userData;
$model=new LatestPoints('search');
$company_id=Yii::app()->user->company_id;
$value = Company::Model()->findByAttributes(array('id'=>$company_id));
$threshold = $value['attributes'];
//echo var_dump($rpmThreshold);

/**-*******-**/
/** Filters **/
/**-*******-**/

$filterMaintenance = Yii::app()->getRequest()->getParam('filterMaintenance');
$filterTrips = Yii::app()->getRequest()->getParam('filterTrips');

if($filterMaintenance){
	$filterMaintenanceChecked = 'checked';
}
if($filterTrips){
	$filterTripsChecked = 'checked';
}
if($filterDrivers){
	$filterDriversChecked = 'checked';
}
echo "<div style='background:white;position: fixed;top: 0px;left: 60px;z-index: 10;width: 100%;padding: 5px;'>";
echo "<strong> Filters: </strong>";
echo "<div style='border:1px solid gray;display:inline'>";
echo "<input type='checkbox' $filterMaintenanceChecked disabled/>";
if ($filterMaintenance){
	echo CHtml::link('Filter Maintenance', array('', 'filterMaintenance'=>false, 'filterTrips'=>$filterTrips),array('class'=>'filterLink'));
}else{
	echo CHtml::link('Filter Maintenance', array('', 'filterMaintenance'=>true, 'filterTrips'=>$filterTrips),array('class'=>'filterLink'));
}
echo "<input type='checkbox' $filterTripsChecked disabled/>";
if ($filterTrips){
	echo CHtml::link('Filter Trips', array('', 'filterTrips'=>false, 'filterMaintenance'=>$filterMaintenance),array('class'=>'filterLink'));
}else{
	echo CHtml::link('Filter Trips', array('', 'filterTrips'=>true, 'filterMaintenance'=>$filterMaintenance),array('class'=>'filterLink'));
}
echo "<input type='checkbox' $filterDriversChecked disabled/>";

echo CHtml::link('clear Filters', array(''),array('class'=>'filterLink'));
echo "</div>";
echo "<strong> Reports: </strong>";
echo "<div style='border:1px solid gray;display:inline'>";
echo CHtml::link('< 50 Km', array('reports/vehiclesLessThanOdo', 'distance'=>50,'filterTrips'=>$filterTrips),array('target'=>'_blank','class'=>'filterLink'));
echo CHtml::link('< 100 Km', array('reports/vehiclesLessThanOdo', 'distance'=>100,'filterTrips'=>$filterTrips),array('target'=>'_blank','class'=>'filterLink'));
echo "</div>";
echo "</div>";

/////////////// filter



//ecolumns Extension
$dialog = $this->widget('ext.ecolumns.EColumnsDialog', array(
       'options'=>array(
            'title' => 'Layout settings',
            'autoOpen' => false,
            'show' =>  'fade',
            'hide' =>  'fade',
        ),
       'htmlOptions' => array('style' => 'display: none'), //disable flush of dialog content
       'ecolumns' => array(
            'gridId' => 'status-grid', //id of related grid
            'storage' => 'cookie',  //where to store settings: 'db', 'session', 'cookie'
            'fixedLeft' => array('CCheckBoxColumn'), //fix checkbox to the left side 
            'model' => $model, //model is used to get attribute labels
            'columns' => array(
				array('header'=>'SN.',
					  'value'=>'++$row',
					'headerHtmlOptions'=>array('style'=>'width: 25px;'),
					'htmlOptions'=>array('style'=>'width: 25px;')
				),
				array(
					"header" => "",
					"type" => "raw",
					'value' => 'CHtml::tag("div",getStatus($data->gps_datetime, $data->last_connection, "GMT",$data->repairId,$data->tripId))',
					'headerHtmlOptions'=>array('style'=>'width: 18px;'),
					'htmlOptions'=>array('style'=>'width: 18px;')
				),
				/*array(
					"header" => "Focus",
					"type" => "raw",
					'value' => 'CHtml::tag("button",array("onclick"=>"javascript:window.opener.changeSelector(\'$data->device_id\')","id"=>"focus$data->device_id"),"Set Focus")',
					'headerHtmlOptions'=>array('style'=>'width: 90px;'),
					'htmlOptions'=>array('style'=>'width: 90px;')
				),
				array(
					"header" => "trace",
					"type" => "raw",
					'value' => 'CHtml::tag("button",array("onclick"=>"javascript:setMarkerTrace(\'$data->device_id\')"),"trace")',
					'headerHtmlOptions'=>array('style'=>'width: 50px;'),
					'htmlOptions'=>array('style'=>'width: 50px;')
				),*/
				
				array(
					"name" => 'vehicle_serial',
					"type" => "raw",
					'value' => 'CHtml::tag("a",array("onclick"=>"javascript:window.opener.changeSelector(\'$data->device_id\')","id"=>"focus$data->device_id","style"=>"cursor:pointer"),$data->vehicle_serial)',
					'headerHtmlOptions'=>array('style'=>'width: 60px;'),
					'htmlOptions'=>array('style'=>'width: 60px;')
				),
			    
				array(
					"name" => 'device_id',
					'headerHtmlOptions'=>array('style'=>'width: 70px;'),
					'htmlOptions'=>array('style'=>'width: 70px;')
				),
				array(
					"name" => "address",
					'headerHtmlOptions'=>array('style'=>'width: 300px'),
					'htmlOptions'=>array('style'=>'width: 300px;direction:rtl')
				),

			   
			   	array(
					"name" => 'speed',
					'headerHtmlOptions'=>array('style'=>'width: 50px;'),
					'htmlOptions'=>array('style'=>'width: 50px;')
				),
			    array(
					"header" => "Latest Update D",
			   		'value'=>'reformDate($data->gps_datetime, Yii::app()->user->timezone)',
					'headerHtmlOptions'=>array('style'=>'width: 75px;'),
					'htmlOptions'=>array('style'=>'width: 75px;')
				),
                
				array(
					"header" => "Latest Update T",
			   		'value'=>'reformTime($data->gps_datetime, Yii::app()->user->timezone)',
					'headerHtmlOptions'=>array('style'=>'width: 75px;'),
					'htmlOptions'=>array('style'=>'width: 75px;')
				),
				array(
					"header" => "Ignition Update D",
					'value'=>'reformDate($data->ignition_time, Yii::app()->user->timezone)',
					'headerHtmlOptions'=>array('style'=>'width: 75px;'),
					'htmlOptions'=>array('style'=>'width: 75px;')
				),

				array(
					"header" => "Ignition Update T",
					'value'=>'reformTime($data->ignition_time, Yii::app()->user->timezone)',
					'headerHtmlOptions'=>array('style'=>'width: 75px;'),
					'htmlOptions'=>array('style'=>'width: 75px;')
				),
			   //'latitude',
			   //'longitude',
			   	array(
					"header" => "Milage",
			   		'value'=>'meterToKm($data->mileage,1)',
					'headerHtmlOptions'=>array('style'=>'width: 90px;'),
					'htmlOptions'=>array('style'=>'width: 90px;')
				),
				array(
					"header" => "Ignition",
			   		"type" => "raw",
					'value'=>'ignitionStat($data->input_status)',
					'headerHtmlOptions'=>array('style'=>'width: 60px;'),
					'htmlOptions'=>array('style'=>'width: 60px;')
				),
			   
			   	array(
					"name" => 'rpm_cam',
                                        "type" => "raw",
                                        "value" => 'checkAlert($data->rpm_cam,'.$threshold['rpm_value'].')',
					'headerHtmlOptions'=>array('style'=>'width: 50px;'),
					'htmlOptions'=>array('style'=>'width: 50px;')
				),
			   
			   	array(
					'name' => 'engine_temp_cam',
                                        "type" => "raw",
                                        "value" => 'checkAlert($data->engine_temp_cam,'.$threshold['engtemp_value'].')',
					'headerHtmlOptions'=>array('style'=>'width: 50px;'),
					'htmlOptions'=>array('style'=>'width: 50px;')
				),
			   
			   	array(
					"name" => 'fuel_level_cam',
                                        "type" => "raw",
                                        "value" => 'checkAlert($data->fuel_level_cam,'.$threshold['fuellevel_value'].')',
					'headerHtmlOptions'=>array('style'=>'width: 50px;'),
					'htmlOptions'=>array('style'=>'width: 50px;')
				),
			   
			   	array(
					"name" => 'fuel_temp_cam',
                                        "type" => "raw",
                                        "value" => 'checkAlert($data->fuel_temp_cam,'.$threshold['fueltemp_value'].')',
					'headerHtmlOptions'=>array('style'=>'width: 50px;'),
					'htmlOptions'=>array('style'=>'width: 50px;')
				),
			   
			   	array(
					"name" => 'fuel_rate_cam',
                                        "type" => "raw",
                                        "value" => 'checkAlert($data->fuel_rate_cam,'.$threshold['fuelrate_value'].')',
					'headerHtmlOptions'=>array('style'=>'width: 50px;'),
					'htmlOptions'=>array('style'=>'width: 50px;')
				),
			   
			   	array(
					"name" => 'oil_press_cam',
                                        "type" => "raw",
                                        "value" => 'checkAlert($data->oil_press_cam,'.$threshold['oilpres_value'].')',
					'headerHtmlOptions'=>array('style'=>'width: 50px;'),
					'htmlOptions'=>array('style'=>'width: 50px;')
				),
			   
			   	array(
					"name" => 'acc_pedal_cam',
                                        "type" => "raw",
                                        "value" => 'checkAlert($data->acc_pedal_cam,'.$threshold['accpedal_value'].')',
					'headerHtmlOptions'=>array('style'=>'width: 50px;'),
					'htmlOptions'=>array('style'=>'width: 50px;')
				),
	


                /*array(
                 'class'=>'CCheckBoxColumn',
				 'id'=>'chk',
                ),*/ 
           ),
       )
    ));
// SelGridView extends CGridView to save the selected row after table updates
$table = $this->widget('zii.widgets.grid.CGridView', array(
       'id' => 'status-grid',
	   'dataProvider'=>$model->search($userData,false,false,$filterTrips,$filterDrivers,$filterMaintenance),
	   'summaryText'=>'',
	   #'blankDisplay'=>'-',
       #'filter'=>$model,
	   //'afterAjaxUpdate'=>'function(id, data){setTableCols()}',

	   'columns' => $dialog->columns(),
		'selectableRows' => 0,
       'template' => $dialog->link()."{summary}\n{items}\n{pager}",
	   /*'ajaxUpdateError'=>'function(xhr,ts,et,err){ 
	   									//$("#myerrordiv").text(err); 
										alert("Session Has Expired, please login again");
										window.location.href = "'.Yii::app()->getBaseUrl().'"; 
		}',*/
	   //'itemsCssClass'=>'table table-striped table-bordered'
	));


function checkAlert($value, $threshold){
    
   If ($value > $threshold){
        echo "<span style='color:red'>".$value."</span>";
        //echo "<span style='color:red'>".$value."</span>";
    }else{
        echo "<span>".$value."</span>";
    }

}


?>
<!--<div id="manualTable">Loading...</div>-->
