<?php
/* @var $this MaintSetupController */
/* @var $model MaintSetup */

$this->breadcrumbs=array(
	'Maint Setups'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th"></i> Back', 'url'=>array('index')),
);
?>

<h1>Update MaintSetup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>