<?php
/* @var $this UserSettingsAdminController */
/* @var $model UserSettingsAdmin */

$this->breadcrumbs=array(
	'User Settings Admins'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List UserSettingsAdmin', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage UserSettingsAdmin', 'url'=>array('admin')),
);
?>

<h1>Create UserSettingsAdmin</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>