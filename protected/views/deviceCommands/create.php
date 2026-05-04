<?php
/* @var $this DeviceCommandsController */
/* @var $model DeviceCommands */

$this->breadcrumbs=array(
	'Device Commands'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'<i class="icon icon-th-list"></i> List Commands', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage Commands', 'url'=>array('index')),
);
?>

<h1>Create DeviceCommands</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>