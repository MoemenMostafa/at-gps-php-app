<?php
/* @var $this DriverController */
/* @var $model Driver */

$this->breadcrumbs=array(
	'Drivers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Driver', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Driver', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View Driver', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage Driver', 'url'=>array('admin')),
);
?>

<h1>Update Driver <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>