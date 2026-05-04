<?php
/* @var $this VehicleDriversController */
/* @var $model VehicleDrivers */

$this->breadcrumbs=array(
	'Vehicle Drivers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List VehicleDrivers', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create VehicleDrivers', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update VehicleDrivers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete VehicleDrivers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage VehicleDrivers', 'url'=>array('admin')),
);
?>

<h1>View VehicleDrivers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'vehicle_id',
		'driver_id',
		'from',
		'to',
	),
)); ?>
