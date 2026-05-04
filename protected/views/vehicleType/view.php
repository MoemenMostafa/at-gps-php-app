<?php
/* @var $this VehicleTypeController */
/* @var $model VehicleType */

$this->breadcrumbs=array(
	'Vehicle Types'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List VehicleType', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create VehicleType', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update VehicleType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete VehicleType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage VehicleType', 'url'=>array('admin')),
);
?>

<h1>View VehicleType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type_ar',
		'type_en',
	),
)); ?>
