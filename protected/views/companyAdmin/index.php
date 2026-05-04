<?php
/* @var $this CompanyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Companies',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Company', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-th"></i> Manage Company', 'url'=>array('admin')),
);
?>

<h1>Companies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
