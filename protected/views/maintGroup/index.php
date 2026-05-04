<?php
/* @var $this MaintGroupController */
/* @var $model MaintGroup */

$this->breadcrumbs=array(
	'Maint Groups'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create MaintGroup', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('maint-group-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Maint Groups</h1>

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

<?php 


    $this->widget('ext.groupgridview.GroupGridView', array(
	'id'=>'maint-group-grid',
	'dataProvider'=>$model->search(),
        'mergeColumns' => array('company.name'),
	'filter'=>$model,
	'columns'=>array(
		
                array(
			"name" => "company.name",
			'value'=>'$data->company->name',
                        'filter'=> CHtml::activeDropDownList($model, 'company_id', CHtml::listData(Company::model()->findAll(),'id','name'), array('empty'=>'ALL')),
		),
                'name',
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{update}{delete}',
		),
	),
)); ?>
