<?php
/* @var $this VehicleController */
/* @var $model Vehicle */

$this->breadcrumbs=array(
	'Vehicles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Vehicle', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage Vehicle', 'url'=>array('admin')),
);
?>

<h1>Create Vehicle</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>