<?php
/* @var $this CommandsController */
/* @var $model Commands */

$this->breadcrumbs=array(
	'Commands'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'<i class="icon icon-th-list"></i> List Commands', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Send Command', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View Command', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage Commands', 'url'=>array('index')),
);
?>

<h1>Update Commands <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>