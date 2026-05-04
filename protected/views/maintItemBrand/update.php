<?php
/* @var $this MaintItemBrandController */
/* @var $model MaintItemBrand */

$this->breadcrumbs=array(
	'Maint Item Brands'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th"></i> Back', 'url'=>array('index')),
);
?>

<h1>Update Maintenance Item Brand <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>