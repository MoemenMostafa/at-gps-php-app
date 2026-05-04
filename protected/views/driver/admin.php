<?php
/* @var $this DriverController */
/* @var $model Driver */

$this->breadcrumbs=array(
	'Drivers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Driver', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Driver', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('driver-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Drivers</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'driver-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'header' => 'ID',

			'htmlOptions'=>array('width'=>'50'),
        ),
		'name',
                'mobile',
		'dob',
                'ibutton',
		array(
			'name' => 'company_id',
			'header' => 'company',
			'value' => '$data->company->name',
			'filter' => $model->getCompanyFilter(),
			'htmlOptions'=>array('width'=>'10'),
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
));


?>
