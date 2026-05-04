<?php
/* @var $this UserSettingsController */
/* @var $model UserSettings */

$this->breadcrumbs=array(
	'User Settings'=>array('index'),
	$model->id,
);
$this->menu=array(
	array('label'=>'<i class="icon icon-pencil"></i> Edit', 'url'=>array('update', 'id'=>$model->id)),
);
?>

<h1>View Sound Alerts Settings</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id0.fullname',
		array(
			'name'=>'geofence',
			'value'=>onOff($model, 'geofence')
		),
		array(
			'name'=>'overspeed',
			'value'=>onOff($model,'overspeed')." (".$model->attributes['overspeed_SoundAlertValue']." Km/h)" 
		),
		array(
			'name'=>'rpm',
			'value'=>onOff($model,'rpm')." (".$model->attributes['rpm_SoundAlertValue']." RPM)"
		),
		array(
			'name'=>'fueltemp',
			'value'=>onOff($model,'fueltemp')." (".$model->attributes['fueltemp_SoundAlertValue']." C)"
		),
		array(
			'name'=>'oilpres',
			'value'=>onOff($model,'oilpres')." (".$model->attributes['oilpres_SoundAlertValue']." bar)"
		),
		array(
			'name'=>'engtemp',
			'value'=>onOff($model,'engtemp')." (".$model->attributes['engtemp_SoundAlertValue']." C)"
		),
		array(
			'name'=>'fuellevel',
			'value'=>onOff($model,'fuellevel')." (".$model->attributes['fuellevel_SoundAlertValue']." %)"
		),
		array(
			'name'=>'fuelrate',
			'value'=>onOff($model,'fuelrate')." (".$model->attributes['fuelrate_SoundAlertValue']." )"
		),
		array(
			'name'=>'accpedal',
			'value'=>onOff($model,'accpedal')." (".$model->attributes['accpedal_SoundAlertValue']." %)"
		)
	),
));

function onOff($model, $value){
		if ($model->attributes[$value] ==0) {return "Off";}
		if ($model->attributes[$value] ==1) {return "On";}
}


?>

