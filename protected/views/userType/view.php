<?php
/* @var $this UserTypeController */
/* @var $model UserType */

$this->breadcrumbs=array(
	'User Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List UserType', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create UserType', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update UserType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete UserType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage UserType', 'url'=>array('admin')),
);
?>

<h1>View UserType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'level',
	),
)); ?>
