<?php
/* @var $this MaintGroupController */
/* @var $model MaintGroup */

$this->breadcrumbs=array(
	'Maint Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th"></i> Back', 'url'=>array('index')),
);
?>

<h1>Create MaintGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>