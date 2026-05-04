<?php
/* @var $this RouteController */
/* @var $model Route */

$this->breadcrumbs=array(
	'Routes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Route', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Route', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View Route', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage Route', 'url'=>array('admin')),
);
?>

<h1>Update Route <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>