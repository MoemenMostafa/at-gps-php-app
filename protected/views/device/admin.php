<?php
/* @var $this DeviceController */
/* @var $model Device */

$this->breadcrumbs=array(
	'Devices'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Device', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Device', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('device-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Devices</h1>

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
	'id'=>'device-grid',
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
		'server_ip',
		'server_port',
		'deviceType.type_en',
		array(
			'name' => 'vehicle_serial_search',
			'header' => 'Assigned Vehicle',
			'value' => 'isset($data->vehicles[0]) ? $data->vehicles[0]->serial : "Unassigned"',
			'filter' => CHtml::activeTextField($model, 'vehicle_serial_search'),
		),
		array(
			'name' => 'latestPoint.gps_datetime',
			'header' => 'Last Update',
			'value' => 'isset($data->latestPoint) ? date("Y-m-d H:i:s", strtotime($data->latestPoint->gps_datetime)) : "Never"',
		),
		'company.name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<script>
$('#bulk-delete-button').click(function(){
    var ids = [];
    // Only look inside tbody to avoid the header checkbox
    $('#device-grid tbody input[type="checkbox"]:checked').each(function(){
        var val = $(this).val();
        if (val) { 
            ids.push(val);
        }
    });
    
    if(ids.length > 0) {
        if(confirm('Are you sure you want to delete ' + ids.length + ' selected items?')) {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl("device/bulkdelete"); ?>',
                data: {ids: ids},
                success: function(data){
                    $.fn.yiiGridView.update('device-grid');
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
