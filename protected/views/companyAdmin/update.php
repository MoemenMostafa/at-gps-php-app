<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Company', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Company', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View Company', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-th"></i> Manage Company', 'url'=>array('admin')),
);
?>

<h1>Update Company <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>