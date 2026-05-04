<?php
/* @var $this DeviceCommandsController */
/* @var $model DeviceCommands */

$this->breadcrumbs=array(
	'Device Commands'=>array('index'),
	$model->name,
);

$this->menu=array(
	//array('label'=>'<i class="icon icon-th-list"></i> List Commands', 'url'=>array('index')),
        array('label'=>'<i class="icon icon-th"></i> Manage Commands', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> New Command', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update Command', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete Command', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View DeviceCommands #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'deviceType.type_en',
		'name',
		'command',
                'UserAvailable',
	),
)); ?>
