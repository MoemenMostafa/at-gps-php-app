<?php
/* @var $this TripController */
/* @var $model Trip */

$this->breadcrumbs=array(
	'Trips'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Trip', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Trip', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View Trip', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage Trip', 'url'=>array('admin')),
);
?>

<h1>Update Trip <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>