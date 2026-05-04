<?php
/* @var $this MaintItemController */
/* @var $model MaintItem */

$this->breadcrumbs=array(
	'Maint Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th"></i> Back', 'url'=>array('index')),
);
?>

<h1>Create MaintItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>