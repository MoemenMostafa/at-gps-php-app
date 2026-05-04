<?php
/* @var $this TripController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Trips',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Trip', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage Trip', 'url'=>array('admin')),
);
?>

<h1>Trips</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
