<?php
/* @var $this CommandsController */
/* @var $model Commands */

$this->breadcrumbs=array(
	'Commands'=>array('index'),
	$model->id,
);

$this->menu=array(
    	array('label'=>'<i class="icon icon-th"></i> Manage Commands', 'url'=>array('index&ajax=command-grid&Commands_sort=id.desc')),
	//array('label'=>'<i class="icon icon-th-list"></i> List Commands', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Send New Command', 'url'=>array('create')),
	//array('label'=>'<i class="icon icon-pencil"></i> Update Command', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete Command', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Commands #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'device_commands_id',
		'device_id',
                'vehicle.serial',
		'status',
                'date_recorded',
                'date_sent',
		'response',
		'date_response',
		
		
	),
)); ?>
