<?php
/* @var $this DriverController */
/* @var $model Driver */

$this->breadcrumbs=array(
	'Drivers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Driver', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Driver', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update Driver', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete Driver', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage Driver', 'url'=>array('admin')),
);
?>

<h1>View Driver #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
                'mobile',
		'dob',
                'ibutton',
	),
)); ?>
