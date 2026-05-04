<?php
/* @var $this LocationController */
/* @var $model Location */

$this->breadcrumbs=array(
	'Locations',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Location', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage Location', 'url'=>array('admin')),
);
?>

<h1>Locations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
)); ?>
