<?php
/* @var $this VehicleTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehicle Types',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create VehicleType', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage VehicleType', 'url'=>array('admin')),
);
?>

<h1>Vehicle Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
