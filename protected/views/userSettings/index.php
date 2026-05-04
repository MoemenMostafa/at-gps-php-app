<?php
/* @var $this UserSettingsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Settings',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create UserSettings', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage UserSettings', 'url'=>array('admin')),
);
?>

<h1>User Settings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
