<?php
/* @var $this VehicleController */
/* @var $model Vehicle */

$this->breadcrumbs=array(
	'Vehicles'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Vehicle', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Vehicle', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View Vehicle', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage Vehicle', 'url'=>array('admin')),
);
?>

<h1>Update Vehicle <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>