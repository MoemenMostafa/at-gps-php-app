<?php
/* @var $this DriverController */
/* @var $model Driver */

$this->breadcrumbs=array(
	'Drivers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Driver', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage Driver', 'url'=>array('admin')),
);
?>

<h1>Create Driver</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>