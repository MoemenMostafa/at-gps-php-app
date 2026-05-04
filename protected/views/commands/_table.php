<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'commands-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,

	'columns'=>array(

            	'id',
		'deviceCommands.name',
		'device_id',
                'vehicle.serial',
            	array(
			"name" => "status",
			'value'=>'$data->Status',
                        'filter'=> CHtml::activeDropDownList($model, 'status', array('0'=>'Recorded','1'=>'Sent','2'=>'Responded'),array('prompt'=>'All')),
		),
                'DateRecorded',
                'DateSent',
		'response',
		'DateResponse',
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{view}  {delete}',
                    'viewButtonUrl' =>'Yii::app()->createUrl("/commands/view", array("id" => $data->id))',
                    'deleteButtonUrl' =>'Yii::app()->createUrl("/commands/delete", array("id" => $data->id))',
        
		),
	),
)); 



?>


<script>
// Set the update interval of the tabel and markers
setInterval(function(){refreshResults();},10000);
	function refreshResults(){
	$.fn.yiiGridView.update("commands-grid");
}



</script>
