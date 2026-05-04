<?php
/* @var $this UserSettingsAdminController */
/* @var $model UserSettingsAdmin */

$this->breadcrumbs=array(
	'User Settings Admins'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List UserSettingsAdmin', 'url'=>array('index')),
	/*array('label'=>'<i class="icon icon-plus-sign"></i> Create UserSettingsAdmin', 'url'=>array('create')),*/
	array('label'=>'<i class="icon icon-pencil"></i> Update UserSettingsAdmin', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete UserSettingsAdmin', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage UserSettingsAdmin', 'url'=>array('admin')),
);
?>

<h1>View UserSettingsAdmin #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id0.fullname',
		array(
			'name'=>'geofence',
			'value'=>$data->geofence=1? "On" : "Off"
		),
		array(
			'name'=>'overspeed',
			'value'=>$data->overspeed=1? "On" : "Off"
		),
		array(
			'name'=>'rpm',
			'value'=>$data->rpm=1? "On" : "Off"
		),
		array(
			'name'=>'fueltemp',
			'value'=>$data->fueltemp=1? "On" : "Off"
		),
		array(
			'name'=>'oilpres',
			'value'=>$data->oilpres=1? "On" : "Off"
		),
		array(
			'name'=>'engtemp',
			'value'=>$data->engtemp=1? "On" : "Off"
		),
		array(
			'name'=>'fuellevel',
			'value'=>$data->fuellevel=1? "On" : "Off"
		),
		array(
			'name'=>'fuelrate',
			'value'=>$data->fuelrate=1? "On" : "Off"
		),
		array(
			'name'=>'accpedal',
			'value'=>$data->accpedal=1? "On" : "Off"
		)
	),
)); ?>
