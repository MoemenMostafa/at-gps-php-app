<?php
/* @var $this DeviceController */
/* @var $model Device */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Device', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Device', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update Device', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete Device', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage Device', 'url'=>array('admin')),
);
?>

<h1>View Device #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'server_ip',
		'server_port',
		'deviceType.type_en',
		array(
			'label' => 'Assigned Vehicle',
			'value' => isset($model->vehicles[0]) ? $model->vehicles[0]->serial . ' ('.$model->vehicles[0]->name.')' : 'Unassigned',
		),
		'company.name',
	),
)); ?>
