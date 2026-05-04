<?php
/* @var $this VehicleTypeController */
/* @var $model VehicleType */

$this->breadcrumbs=array(
	'Vehicle Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List VehicleType', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage VehicleType', 'url'=>array('admin')),
);
?>

<h1>Create VehicleType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>