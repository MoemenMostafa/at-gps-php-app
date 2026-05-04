<?php
/* @var $this MaintGroupController */
/* @var $model MaintGroup */

$this->breadcrumbs=array(
	'Maint Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th"></i> Back', 'url'=>array('index')),
);
?>

<h1>Update MaintGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>