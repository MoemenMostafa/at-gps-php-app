<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Companies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Company', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage Company', 'url'=>array('admin')),
);
?>

<h1>Create Company</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>