<?php
/* @var $this VehicleDriversController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehicle Drivers',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create VehicleDrivers', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage VehicleDrivers', 'url'=>array('admin')),
);
?>

<h1>Vehicle Drivers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
