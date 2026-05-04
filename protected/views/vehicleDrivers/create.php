<?php
/* @var $this VehicleDriversController */
/* @var $model VehicleDrivers */

$this->breadcrumbs=array(
	'Vehicle Drivers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List VehicleDrivers', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage VehicleDrivers', 'url'=>array('admin')),
);
?>

<h1>Create VehicleDrivers</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>