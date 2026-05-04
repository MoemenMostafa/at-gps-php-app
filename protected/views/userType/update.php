<?php
/* @var $this UserTypeController */
/* @var $model UserType */

$this->breadcrumbs=array(
	'User Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List UserType', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create UserType', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View UserType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage UserType', 'url'=>array('admin')),
);
?>

<h1>Update UserType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>