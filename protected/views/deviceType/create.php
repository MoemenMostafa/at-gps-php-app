<?php
/* @var $this DeviceTypeController */
/* @var $model DeviceType */

$this->breadcrumbs=array(
	'Device Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List DeviceType', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage DeviceType', 'url'=>array('admin')),
);
?>

<h1>Create DeviceType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>