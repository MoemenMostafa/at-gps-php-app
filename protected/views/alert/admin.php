<?php
/* @var $this AlertController */


/*if(Yii::app()->user->isAdmin())
     echo 'Is administrator';*/


$user_id = Yii::app()->user->id;

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Vehicle', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Vehicle', 'url'=>array('create')),
);


// Include the client scripts
$baseUrl = Yii::app()->baseUrl; 
Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/ajaxAlertStatus.js');

?>



<div style="overflow:auto">
<h1 style=" float:left">Alerts</h1>
<h5 style=" float:left;color:gray"> (Beta) </h5>
</div>



<div class="search-form">
	<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
        'id'=>'filter',
    )); ?>
    
        <div class="row">
            <?php echo $form->dropDownList($model,'type',array('1'=>'Geofence','2'=>'speeding','3'=>'RPM','4'=>'Fuel Temp.','5'=>'Oil Pressure','6'=>'Engine Temp.','7'=>'Fuel Level','8'=>'Fuel Rate','9'=>'Acc. Pedal'),array('empty' => 'All Alert Types')); ?>
            <?php echo $form->error($model,'type'); ?>
            
            <?php echo $form->dropDownList($model,'status',array('0'=>'not checked','1'=>'checked'),array('empty' => 'All Status')); ?>
            <?php echo $form->error($model,'status'); ?>
        </div>
        
    <?php $this->endWidget(); ?>
</div>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'alert-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'vehicle.serial',
		'AlertType',
		'value',
		'max_value',
		array(
			"name" => "first_occurrence",
			'value'=>'setDateTime($data->first_occurrence, Yii::app()->user->timezone)',
		),
		array(
			"name" => "last_occurrence",
			'value'=>'setDateTime($data->last_occurrence, Yii::app()->user->timezone)',
		),
            	array(
			"name" => "duration",
			"type" => "raw",
		),
		'users.fullname',
		array(
			"header" => "Cehck",
			"type" => "raw",
			'value' => 'CHtml::checkBox("status",$data->Status,array("value"=>"$data->id","onclick"=>"javascript:toggleStatus($data->id,$data->status,'.$user_id.')"));',
		),
	/*
		array(
			'class'=>'CButtonColumn',
		),*/
	),
)); 



Yii::app()->clientScript->registerScript('search', "
$('.search-form form').change(function(){
	$.fn.yiiGridView.update('alert-grid', {
		data: $(this).serialize()
	});
	return false;
});
");



?>

<script>
// Set the update interval of the tabel and markers
var refreshInterval = setInterval(function(){refreshResults()},10000);
function refreshResults(){
$.fn.yiiGridView.update("alert-grid");
};


</script>
