<?php
/* @var $this DeviceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Devices',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Device', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage Device', 'url'=>array('admin')),
);
?>

<h1>Devices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
