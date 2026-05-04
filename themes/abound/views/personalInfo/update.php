<?php
$this->breadcrumbs=array(
	'Personal Infos'=>array('index'),
	$model->pesonal_info_id=>array('view','id'=>$model->pesonal_info_id),
	'Update',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List PersonalInfo','url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create PersonalInfo','url'=>array('create')),
	array('label'=>'<i class="icon icon-search"></i> View PersonalInfo','url'=>array('view','id'=>$model->pesonal_info_id)),
	array('label'=>'<i class="icon icon-th"></i> Manage PersonalInfo','url'=>array('admin')),
);
?>

<h1>Update PersonalInfo <?php echo $model->pesonal_info_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>