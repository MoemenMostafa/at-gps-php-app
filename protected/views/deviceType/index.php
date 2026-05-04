<?php
/* @var $this DeviceTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Device Types',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create DeviceType', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage DeviceType', 'url'=>array('admin')),
);
?>

<h1>Device Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
