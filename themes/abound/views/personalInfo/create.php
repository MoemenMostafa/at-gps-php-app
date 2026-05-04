<?php
$this->breadcrumbs=array(
	'Personal Infos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List PersonalInfo','url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage PersonalInfo','url'=>array('admin')),
);
?>

<h1>Create PersonalInfo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>