<?php
/* @var $this SpeedZoneController */
/* @var $model SpeedZone */

$this->breadcrumbs=array(
	'SpeedZones',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Speed Zone', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage Speed Zone', 'url'=>array('admin')),
);
?>

<h1>Speed Zones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
)); ?>
