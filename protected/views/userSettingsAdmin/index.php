<?php
/* @var $this UserSettingsAdminController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Settings Admins',
);

$this->menu=array(
	/*array('label'=>'<i class="icon icon-plus-sign"></i> Create UserSettingsAdmin', 'url'=>array('create')),*/
	array('label'=>'<i class="icon icon-th"></i> Manage UserSettingsAdmin', 'url'=>array('admin')),
);
?>

<h1>User Settings Admins</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
