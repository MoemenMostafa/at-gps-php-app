<?php
/* @var $this CommandsController */
/* @var $model Commands */

$this->breadcrumbs=array(
	'Commands'=>array('index'),
	'Send',
);

$this->menu=array(
	//array('label'=>'<i class="icon icon-th-list"></i> List Commands', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage Commands', 'url'=>array('index&ajax=command-grid&Commands_sort=id.desc')),
);
?>

<h1>Send Command</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>