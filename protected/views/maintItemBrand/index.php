<?php
/* @var $this MaintItemBrandController */
/* @var $model MaintItemBrand */

$this->breadcrumbs=array(
	'Maint Item Brands'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-plus-sign"></i> Create MaintItemBrand', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('maint-item-brand-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Maint Item Brands</h1>

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

<?php $this->widget('ext.groupgridview.GroupGridView', array(
	'id'=>'maint-item-brand-grid',
	'dataProvider'=>$model->search(),
        'mergeColumns' => array('maintGroup.name','company.name'),
	'filter'=>$model,
	'columns'=>array(
            'company.name',    
            'maintGroup.name',
		'name',
		
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{update}   {delete}',
		),
	),
)); ?>
