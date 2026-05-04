<?php
/* @var $this RouteController */
/* @var $model Route */

$this->breadcrumbs=array(
	'Routes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Route', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-plus-sign"></i> Create Route', 'url'=>array('create')),
	array('label'=>'<i class="icon icon-pencil"></i> Update Route', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'<i class="icon icon-remove"></i> Delete Route', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'<i class="icon icon-th"></i> Manage Route', 'url'=>array('admin')),
);
?>

<h1>View Route #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'company.name',
		'name',
		array(
			'name'=>'points',
			"type" => "raw",
			'value'=>'<div id="map_canvas" style="width:100%; height:400px"></div>',
    	),
		array(
			'name'=>'Export',
			"type" => "raw",
			'value'=>'<button onclick="exportKML(\'test.kml\')">KML</button>'
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

			function exportKML(filename) {
				var coordinates = '<?php echo $model->points ?>';
				coordinates = coordinates.replace(/ /g,'').replace(/\),/g,';').replace(/\(/g,'').replace(/\)/g,'');
				var coordObj = coordinates.split(';');
				var modCoordinates = "\n";
				coordObj.forEach(function(latlong){
					var latlong = latlong.split(",");
					var lat = latlong[1];
					var long = latlong[0];
					modCoordinates += lat +","+long +"\n" ;
				});
//				console.log(modCoordinates);
				var text = '<\?xml version="1.0" encoding="UTF-8"?>\n' +
					'<kml xmlns="http://earth.google.com/kml/2.1">\n' +
					'<Document>\n' +
					'<name>KML Name</name>\n' +
					'<description>KML Description</description>\n' +
					'<Style id="style1">\n' +
					'<LineStyle>\n' +
					'<color>990000ff</color>\n' +
					'<width>4</width>\n' +
					'</LineStyle>\n' +
					'<PolyStyle>\n' +
					'<color>330000ff</color>\n' +
					'</PolyStyle> </Style>\n' +
					'<Placemark>\n' +
					'<name>Polygon1</name>\n' +
					'<description></description>\n' +
					'<styleUrl>#style1</styleUrl>\n' +
					'<Polygon>\n' +
					'<altitudeMode>relative</altitudeMode>\n' +
					'<LinearRing>\n' +
					'<coordinates>';
				text += modCoordinates;
				text += '</coordinates>\n' +
					'</LinearRing>\n' +
					'</Polygon>\n' +
					'</Placemark>\n' +
					'</Document>\n' +
					'</kml>';
				var element = document.createElement('a');
				element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
				element.setAttribute('download', filename);

				element.style.display = 'none';
				document.body.appendChild(element);

				element.click();

				document.body.removeChild(element);
			}
</script>