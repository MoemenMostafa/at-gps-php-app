<?php
/* @var $this TripController */
/* @var $model Trip */

$this->breadcrumbs=array(
	'Trips'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Trip', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Trip', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trip-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Trips</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trip-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'vehicle.serial',
		array(
			'name' => 'vehicle_id',
			'header' => 'Vehicle No.',
			'value' => '$data->vehicle->serial',
			'filter' => $model->getVehicleFilter(),
			'htmlOptions'=>array('width'=>'10'),
		),
		array(
			'name' => 'route_id',
			'header' => 'Route',
			'value' => '$data->route->name',
			'filter' => $model->getRouteFilter(),
		),
		array(
			'name' => 'driver_id',
			'header' => 'Driver',
			'value' => '$data->driver->name',
			'filter' => $model->getDriverFilter(),
		),
		'company.name',
		'fromLocal',
		'toLocal',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
