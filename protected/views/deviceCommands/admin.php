<?php
/* @var $this DeviceCommandsController */
/* @var $model DeviceCommands */

$this->breadcrumbs=array(
	'Device Commands'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'<i class="icon icon-th-list"></i> List Commands', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> New Command', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('device-commands-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Device Commands</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('ext.groupgridview.GroupGridView', array(
	'id'=>'device-commands-grid',
	'dataProvider'=>$model->search(),
        'mergeColumns' => array('deviceType.type_en'),  
	'filter'=>$model,
	'columns'=>array(
		//'id',
		
            	array(
			"name" => "deviceType.type_en",
			'value'=>'$data->deviceType->type_en',
                        'filter'=> CHtml::activeDropDownList($model, 'device_type_id', CHtml::listData(DeviceType::model()->findAll(),'id','type_en'), array('empty'=>'ALL')),
		),
		'name',
		'command',
		array(
			"name" => "user_available",
			'value'=>'$data->UserAvailable',
                        'filter'=> CHtml::activeDropDownList($model, 'user_available', array(''=>'All','0'=>'No','1'=>'Yes')),
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
