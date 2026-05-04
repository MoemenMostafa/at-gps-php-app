<?php
/* @var $this VehicleController */
/* @var $model Vehicle */

$this->breadcrumbs=array(
	'Vehicles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Vehicle', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Vehicle', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('vehicle-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Vehicles</h1>

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
echo CHtml::button('Delete Selected', array(
    'id' => 'bulk-delete-button',
    'class' => 'btn btn-danger',
    'style' => 'margin-bottom: 10px; float: right;',
)); 
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vehicle-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'value' => '$data->id',
            'checkBoxHtmlOptions' => array('name' => 'selectedIds[]', 'class' => 'selectedIds'),
        ),
		'id',
		'device_id',
		'name',
		'serial',
		'model',
		'colour',
		array('header'=>'Vehicle Type','name'=>'vehicleType.type_en','value'=>$model->vehicleType->type_en,),
		array(
			'name' => 'company_id',
			'header' => 'company',
			'value' => '$data->company->name',
			'htmlOptions'=>array('width'=>'10'),
        ),
		array(
			'name' => 'latestPoints.gps_datetime',
			'header' => 'Last Update',
			'value' => 'isset($data->latestPoints) ? date("Y-m-d H:i:s", strtotime($data->latestPoints->gps_datetime)) : "Never"',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<script>
$('#bulk-delete-button').click(function(){
    var ids = [];
    // Only look inside tbody to avoid the header checkbox
    $('#vehicle-grid tbody input[type="checkbox"]:checked').each(function(){
        var val = $(this).val();
        if (val) { 
            ids.push(val);
        }
    });
    
    if(ids.length > 0) {
        if(confirm('Are you sure you want to delete ' + ids.length + ' selected items? This will also remove associated hardware (devices).')) {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl("vehicle/bulkdelete"); ?>',
                data: {ids: ids},
                success: function(data){
                    $.fn.yiiGridView.update('vehicle-grid');
                    alert(data);
                },
                error: function(data){
                    alert("Error occurred. Please try again.");
                }
            });
        }
    } else {
        alert('Please select at least one item by checking the boxes on the left.');
    }
});
</script>
