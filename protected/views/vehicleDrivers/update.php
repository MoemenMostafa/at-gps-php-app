<?php
/* @var $this VehicleDriversController */
/* @var $model VehicleDrivers */

$this->breadcrumbs=array(
	'Vehicle Drivers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List VehicleDrivers', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create VehicleDrivers', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View VehicleDrivers', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage VehicleDrivers', 'url'=>array('admin')),
);
?>

<h1>Update VehicleDrivers <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>