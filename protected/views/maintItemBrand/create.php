<?php
/* @var $this MaintItemBrandController */
/* @var $model MaintItemBrand */

$this->breadcrumbs=array(
	'Maint Item Brands'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th"></i> Back', 'url'=>array('index')),
);
?>

<h1>Create Maintenance Item Brand</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>