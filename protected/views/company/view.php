<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Company'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-pencil"></i> Update Company Details', 'url'=>array('update', 'id'=>$model->id)),
);
?>

<h1>View Company Details</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'address',
		'country.name',
		'timezone.timezone'
	),
)); ?>
