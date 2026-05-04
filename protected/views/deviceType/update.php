<?php
/* @var $this DeviceTypeController */
/* @var $model DeviceType */

$this->breadcrumbs=array(
	'Device Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List DeviceType', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create DeviceType', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View DeviceType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage DeviceType', 'url'=>array('admin')),
);
?>

<h1>Update DeviceType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>