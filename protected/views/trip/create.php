<?php
/* @var $this TripController */
/* @var $model Trip */

$this->breadcrumbs=array(
	'Trips'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Trip', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage Trip', 'url'=>array('admin')),
);
?>

<h1>Create Trip</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>