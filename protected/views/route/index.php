<?php
/* @var $this RouteController */
/* @var $model Route */

$this->breadcrumbs=array(
	'Routes',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Route', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage Route', 'url'=>array('admin')),
);
?>

<h1>Routes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
)); ?>
