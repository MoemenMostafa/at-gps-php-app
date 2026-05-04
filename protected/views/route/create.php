<?php
/* @var $this RouteController */
/* @var $model Route */
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
	'Routes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'<i class="icon icon-th-list"></i> List Route', 'url'=>array('index')),
	array('label'=>'<i class="icon icon-th"></i> Manage Route', 'url'=>array('admin')),
);
?>

<h1>Create Route</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>