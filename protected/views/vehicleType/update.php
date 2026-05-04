<?php
/* @var $this VehicleTypeController */
/* @var $model VehicleType */

$this->breadcrumbs=array(
	'Vehicle Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List VehicleType', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create VehicleType', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View VehicleType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage VehicleType', 'url'=>array('admin')),
);
?>

<h1>Update VehicleType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>