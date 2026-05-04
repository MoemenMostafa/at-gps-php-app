<?php
/* @var $this UserTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Types',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create UserType', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage UserType', 'url'=>array('admin')),
);
?>

<h1>User Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
