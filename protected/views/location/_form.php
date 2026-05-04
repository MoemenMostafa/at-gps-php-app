<?php
/* @var $this LocationController */
/* @var $model Location */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'location-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php
			$records = Company::model()->findAll();
			$list = CHtml::listData($records, 'id', 'name');
    	?>
        <?php echo $form->dropDownList($model,'company_id',$list,array('empty' => '(Select a Company)')); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>
    
	<div class="row">
    	<?php echo $form->labelEx($model,'Draw Fence *'); ?>
        
        <div class="test">
        <?php echo $form->labelEx($model,'Load Trip'); ?>
            <?php
                $records =  Vehicle::model()->search("list",true);
		$list = CHtml::listData($records, 'id', 'serial', 'name');
            ?>
            <?php echo $form->dropDownList(Vehicle::model(),'id',$list,array('empty' => '(Select Vehicle)',
                'options'=>array($vehicleId=>array('selected'=>'selected'))
            )); ?>
            <?php echo $form->error(Vehicle::model(),'serial'); ?>
            <?php echo $form->labelEx($model,'Time Range:',array('style'=>'width:150px;text-align:center')); ?>
            <?php 
			$this->widget('ext.EDateRangePicker.EDateRangePicker',array(
				'id'=>'dateRange',
				'name'=>'Vehicle[dateRange]',
				'value'=>$from." - ".$to,
				'options'=>array('arrows'=>false,'dateFormat'=>'dd/mm/yy'),
				'htmlOptions'=>array('class'=>'inputClass'),
            ));
        	?>
   			<button id="loadButton" type="button" data-loading-text="Loading..." class="btn">Load</button>
             
            <div id="map_canvas" style="width:100%; height:400px"></div>
            <?php echo $form->hiddenField($model,'points',array('rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->error($model,'points'); ?>

        </div>
    
		<?php
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->params['mapsUrl']);
        ?>
        <script>
         initialize_map();
        function initialize_map()
        {
         
			 var loadPoints = $('#Location_points').val();
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
				editable:true
			  });
			 
			 var bounds = new google.maps.LatLngBounds();
			 
			 for (var i = 0; i < editablePolygonPoints.length; i++) {
				  bounds.extend(editablePolygonPoints[i]);
				}
			 
			 // Initializing a map
			 var latlng = new google.maps.LatLng(26.392971,30.954051); // latitude is 29.392971,longitude: 79.454051
			 var myOptions = {
			 zoom: 5,
			 center: latlng,
			 mapTypeId: google.maps.MapTypeId.ROADMAP
			 };
			 // Draw a map on DIV "map_canvas"
			 map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			 // Listen Click Event to draw Polygon
			 google.maps.event.addListener(map, 'click', function(event) {
			 polyCoordinates[count] = event.latLng;
			 createPolyline(polyCoordinates);
			 count++;
			 });
			
			// Load Polygon drawingMode only in the create view
			var drawPolygon;
			if(editablePolygonPoints.length<=1){
				 drawPolygon = 	google.maps.drawing.OverlayType.POLYGON;
			}
			
			 var drawingManager = new google.maps.drawing.DrawingManager({
			  drawingControl: true,
			  drawingControlOptions: {
				position: google.maps.ControlPosition.TOP_CENTER,
				drawingModes: [
				  drawPolygon
				]
			  },
			  polygonOptions: {
				  
				editable: true  
			  }
			});
			drawingManager.setMap(map);
			
			
			
			// Check if the editablePolygonPoints are loaded to fit map to bounds
			if(editablePolygonPoints.length>1){
				editablePolygon.setMap(map);
				map.fitBounds(bounds);
			}
			
			google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
					var points = event.overlay.getPath();
					xy = updatePoints(points);
					$('#Location_points').val(xy);  
					this.setDrawingMode(null);
					this.setOptions({drawingControl:false});
			
			google.maps.event.addListener(points, 'set_at', function() {
				 xy = updatePoints(points);
				 $('#Location_points').val(xy);
				});
			google.maps.event.addListener(points, 'insert_at', function() {
				  xy = updatePoints(points);
				  $('#Location_points').val(xy);
				});
			google.maps.event.addListener(points, 'remove_at', function() {
				  xy = updatePoints(points);
				  $('#Location_points').val(xy);
				});
			});
			
			google.maps.event.addListener(editablePolygon, 'mouseout', function(event) {
				var points = this.getPath();
				xy = updatePoints(points);
				$('#Location_points').val(xy);
				
			});
        }
		var lineSymbol = {
		  path: google.maps.SymbolPath.FORWARD_OPEN_ARROW
		};
		
		var polyOptions = {
			strokeColor: 'red',
			strokeOpacity: 1.0,
			strokeWeight: 2,
			icons: [{
				icon: lineSymbol,
				offset: '100%',
				repeat: '100px'
			  }],
		}

		poly = new google.maps.Polyline(polyOptions);
		
		$("#loadButton").click(function(){
			$(this).html('loading...');
                        $(this).prop('disabled', true);
			if(poly.length >0){
				 poly.setMap(null);
				 poly = new google.maps.Polyline(polyOptions);
			}
			var path = new  google.maps.MVCArray;
			poly.setMap(map);
		  var jsonData = $.getJSON("loadTrip.php?vehicleId="+$("#Vehicle_id").val()+"&range="+$("#dateRange").val(),
		  function(){

		  })
                  .done(function(data){
                        poly.setPath(path);
                        if (data != null){
                    	var bounds = new google.maps.LatLngBounds();
				
			$.each(data, function(key, val) {
                        path.push(new google.maps.LatLng(val.latitude, val.longitude));
                                        point = new google.maps.LatLng(val.latitude, val.longitude);
                                        bounds.extend(point);
                        });
			//alert("Data: " + data);
                         // now update your polyline to use this path
                        poly.setPath(path);
			
			map.fitBounds(bounds);
                        }
                        
                        $('#loadButton').prop('disabled', false);
                        $('#loadButton').html('load');
                  })
                  .fail(function() { console.log( "error" ); });
                  
                  
		});

		
        function updatePoints(points){
        	 // Iterate over the vertices.
        	 var xy = Array();
          	for (var i =0; i < points.length; i++) {
            xy[i] = points.getAt(i);
            
          }
		  return xy;
		}
        </script>

	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->