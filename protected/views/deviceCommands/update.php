<?php
/* @var $this DeviceCommandsController */
/* @var $model DeviceCommands */

$this->breadcrumbs=array(
	'Device Commands'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'<i class="icon icon-th-list"></i> List Commands', 'url'=>array('index')),
        array('label'=>'<i class="icon icon-th"></i> Manage Commands', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> New Command', 'url'=>array('create')),
	//array('label'=>'<i class="icon icon-search"></i> View Commands', 'url'=>array('view', 'id'=>$model->id)),
	
);
?>

<h1>Update DeviceCommands <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>