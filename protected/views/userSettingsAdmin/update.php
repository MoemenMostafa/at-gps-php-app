<?php
/* @var $this UserSettingsAdminController */
/* @var $model UserSettingsAdmin */

$this->breadcrumbs=array(
	'User Settings Admins'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List UserSettingsAdmin', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create UserSettingsAdmin', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View UserSettingsAdmin', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage UserSettingsAdmin', 'url'=>array('admin')),
);
?>

<h1>Update UserSettingsAdmin <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>