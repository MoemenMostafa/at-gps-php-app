<?php
/* @var $this DeviceController */
/* @var $model Device */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Device', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Device', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View Device', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage Device', 'url'=>array('admin')),
);
?>

<h1>Update Device <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>