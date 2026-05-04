<?php
/* @var $this SpeedZoneController */
/* @var $model SpeedZone */

$this->breadcrumbs=array(
	'SpeedZones'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Speed Zone', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Speed Zone', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View Speed Zone', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage Speed Zone', 'url'=>array('admin')),
);
?>

<h1>Update Speed Zone <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>