<?php
/* @var $this SpeedZoneController */
/* @var $model SpeedZone */

$this->breadcrumbs=array(
	'SpeedZones'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Speed Zone', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Speed Zone', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update Speed Zone', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete Speed Zone', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage Speed Zone', 'url'=>array('admin')),
);
?>

<h1>View Speed Zone #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'company.name',
		'name',
		'speed_limit',
		array(
			'name'=>'points',
			"type" => "raw",
			'value'=>'<div id="map_canvas" style="width:100%; height:400px"></div>',
    	)
	),
)); ?>
		<?php
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->params['mapsUrl']);
        ?>
<script>
			var loadPoints = '<?php echo $model->points ?>';
			//loadPoints = loadPoints.replace(/\),\(/g,"):(");
			loadPoints = loadPoints.replace(/\)/g,"");
			loadPoints = loadPoints.replace(/\(/g,"");
			
			var n=loadPoints.split(",");
			var editablePolygonPoints = [];
			var x=0;
			for (var i =0; i < n.length ; i++) {
				editablePolygonPoints[x] = new google.maps.LatLng(n[i],n[++i]);
				x++;
			 }
			  editablePolygon = new google.maps.Polygon({
				paths: editablePolygonPoints,
				editable:false
			  });
			 
			 var bounds = new google.maps.LatLngBounds();
			 
			 for (var i = 0; i < editablePolygonPoints.length; i++) {
				  bounds.extend(editablePolygonPoints[i]);
			}
			
			var latlng = new google.maps.LatLng(26.392971,30.954051); // latitude is 29.392971,longitude: 79.454051
			 var myOptions = {
			 zoom: 5,
			 center: latlng,
			 disableDefaultUI: true,
			 mapTypeId: google.maps.MapTypeId.ROADMAP
			 };
			 // Draw a map on DIV "map_canvas"
			 map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			
			// Check if the editablePolygonPoints are loaded to fit map to bounds
			if(editablePolygonPoints.length>1){
				editablePolygon.setMap(map);
				map.fitBounds(bounds);
			}
</script>