<?php
/* @var $this DeviceTypeController */
/* @var $model DeviceType */

$this->breadcrumbs=array(
	'Device Types'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List DeviceType', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create DeviceType', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update DeviceType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete DeviceType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage DeviceType', 'url'=>array('admin')),
);
?>

<h1>View DeviceType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type_ar',
		'type_en',
		'data_arrange',
		'value_arrange'
	),
)); ?>
