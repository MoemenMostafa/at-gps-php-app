<?php
/* @var $this LocationController */
/* @var $model Location */
			//Create Map
			
			//$gMap->zoom = 6;
			/*$gpsData = $data;
			foreach($gpsData as $gpsLocation){
				
			
			$coords[] = new EGMapCoord($gpsLocation->attributes['latitude'], $gpsLocation->attributes['longitude']);
			}
			$polylines = new EGMapPolyline($coords);
			
			
			//adding the polylines
			$gMap->addPolyline($polylines);
			$gMap->centerOnPolylines();
			$gMap->zoomOnPolylines(0.1);*/
			//$gMap->setWidth('100%');

$this->breadcrumbs=array(
	'Locations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Location', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage Location', 'url'=>array('admin')),
);
?>

<h1>Create Location</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>