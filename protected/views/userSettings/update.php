<?php
/* @var $this UserSettingsController */
/* @var $model UserSettings */

$this->breadcrumbs=array(
	'User Settings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-search"></i> View UserSettings', 'url'=>array('index', 'id'=>$model->id)),
);
?>

<h1>Update Sound Alerts Settings</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>