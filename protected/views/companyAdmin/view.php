<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Company', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Company', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update Company', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete Company', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage Company', 'url'=>array('admin')),
);
?>

<h1>View Company #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'address',
		'country.name',
		'timezone.TimeZone',
		'overspeed_value',
		'rpm_value',
		'fueltemp_value',
		'oilpres_value',
		'engtemp_value',
		'fuellevel_value',
		'fuelrate_value',
		'accpedal_value',
	),
)); ?>
