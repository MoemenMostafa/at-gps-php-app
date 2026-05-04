<?php
/* @var $this LocationController */
/* @var $model Location */

$this->breadcrumbs=array(
	'Locations'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Location', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Location', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View Location', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage Location', 'url'=>array('admin')),
);
?>

<h1>Update Location <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>