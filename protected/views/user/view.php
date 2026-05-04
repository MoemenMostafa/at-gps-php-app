<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->fullname,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-pencil"></i> Update Personal Settings', 'url'=>array('update', 'id'=>$model->id)),
);
?>

<h1>User: <?php echo $model->fullname; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'email',
		//'password',
		'fullname',
		'title',
		'company.name',
		'userType.name',
		),
)); ?>