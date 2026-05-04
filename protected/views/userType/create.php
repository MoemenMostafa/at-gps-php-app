<?php
/* @var $this UserTypeController */
/* @var $model UserType */

$this->breadcrumbs=array(
	'User Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List UserType', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage UserType', 'url'=>array('admin')),
);
?>

<h1>Create UserType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>