<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-search"></i> View Company Details', 'url'=>array('index', 'id'=>$model->id)),
);
?>

<h1>Update Company Details</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>