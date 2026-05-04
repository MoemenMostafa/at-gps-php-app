<?php
/* @var $this TripController */
/* @var $model Trip */

$this->breadcrumbs=array(
	'Trips'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Trip', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Trip', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update Trip', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete Trip', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage Trip', 'url'=>array('admin')),
);
?>

<h1>View Trip #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'vehicle.serial',
		'route.name',
		'driver.name',
		'company.name',
		'from',
		'to',
	),
)); ?>
