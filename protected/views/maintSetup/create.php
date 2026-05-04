<?php
/* @var $this MaintSetupController */
/* @var $model MaintSetup */

$this->breadcrumbs=array(
	'Maint Setups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th"></i> Back', 'url'=>array('index')),
);
?>

<h1>Create MaintSetup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>