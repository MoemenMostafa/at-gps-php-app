<?php
/* @var $this VehicleController */
/* @var $model Vehicle */

$this->breadcrumbs=array(
	'Vehicles'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Vehicle', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Vehicle', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update Vehicle', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete Vehicle', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage Vehicle', 'url'=>array('admin')),
);
?>

<h1>View Vehicle #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'device_id',
		'name',
		'serial',
		'model',
		'colour',
		array('name'=>'Vehicle Type','value'=>$model->vehicleType->type_en),
		array('name'=>'Company','value'=>$model->company->name),
	),
)); ?>
