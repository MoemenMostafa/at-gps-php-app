<?php
/* @var $this DriverController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Drivers',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Driver', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage Driver', 'url'=>array('admin')),
);
?>

<h1>Drivers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
