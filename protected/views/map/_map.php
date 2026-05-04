<?php
/*********************/
/** Map Starts here **/
/*********************/

// Register jquery layout
	$baseUrl = Yii::app()->theme->baseUrl; 
	$cs = Yii::app()->getClientScript();


$gMap = new EGMap();
$gMap->zoom = 7;
$mapTypeControlOptions = array(
  'position'=> EGMapControlPosition::RIGHT_TOP,
  'style'=>EGMap::MAPTYPECONTROL_STYLE_DROPDOWN_MENU
);
$gMap->setWidth('100%');
$gMap->setHeight('100%');
$gMap->mapTypeControlOptions= $mapTypeControlOptions;
$gMap->setAPIKey("at-gps.com", "AIzaSyCMtIMZsa1Oq5eJhlIHVcQW_K02kIVAt5I");
 
 
 
$gMap->setCenter(30.0500, 31.2400);

$gMap->addEvent(new EGMapEvent('click','function (event) {
    google.maps.event.addListener('.$gMap->getJsName().', "click", function(event) {
    if (editableLandmarks){
        $("#Landmarks_lat").val(event.latLng.lat());
        $("#Landmarks_long").val(event.latLng.lng());
        $("#LandmarksModalLabel").html("Add New Landmark");
        $("#Landmarks_name").val("");
        $("#landmark-action").val("");
        $("#Landmarks_icon").val("");
        $("#Landmarks_id").val("");
        $("#icon_view").attr("src","");
        $("#LandmarksModal").modal("show");
    }
});}', false, EGMapEvent::TYPE_EVENT_DEFAULT_ONCE));



$gMap->renderMap(array(), Yii::app()->language);

//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/oms.min.js');

// load markers functions
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/marker.js');


?>
<button class="mapButton" style="position:absolute;right:100px;top:5px;" onclick="vehiclesDetails()">All Vehicles Details</button>
<button id ="locationsButton" class="mapButton" style="position:absolute;right:100px;top:30px;" onclick="showLocations(<?php echo $userCompanyId; ?>)">Show Locations</button>
<button id ="landmarksButton" class="mapButton" style="position:absolute;right:100px;top:55px;" onclick="editLandmarks(<?php echo $userCompanyId; ?>)">Edit Landmarks</button>

<div class="locationOverlay" style="position:absolute;right:5px;top:70px;">	
    <?php
        $records = Location::model()->search("list");
        $list = CHtml::listData($records, 'id', 'name');
        echo CHtml::dropDownList('Location','id',$list,
                array(
                        'empty' => '(Select a Location)',
                        'style'=>'width:180px',
			'onchange' => "if(this.value){setLocationFocus(this.value);getVehiclesInLocation($userCompanyId,this.value);}else{showAllMarkers();getVehiclesInLocation();}",
                    ));
    ?>
    <div id="vehiclesInLocationSum"></div>
    <div id="vehiclesInLocationList"></div>
</div>

<script>

var bounds;
// Wait until all elements are loaded
window.onload = function() {
    this.loadScript('<?php echo Yii::app()->baseUrl; ?>/js/markerwithlabel.js',()=>{
        // load markers
        setTimeout(()=>markerManager(<?php echo $userCompanyId; ?>,<?php echo Yii::app()->user->id; ?>),500);
        bounds = new google.maps.LatLngBounds();
        // Center the map to all markers bound center after 3 s
	    setTimeout(showAllMarkers,3000);
    })
};


function loadScript(url, callback){

    var script = document.createElement("script")
    script.type = "text/javascript";

    if (script.readyState){  //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" ||
                    script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  //Others
        script.onload = function(){
            callback();
        };
    }

    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

function vehiclesDetails(){
	h = screen.height*0.30;
	w = screen.width-15;
	t = (screen.height*0.70)-100;
		window.open('<?php echo Yii::app()->createUrl("/table") ?>',"Table","width="+w+",height="+h+",top="+t+",status=0,location=0"); 	
}

function placeMarker(location) {
    var marker = new google.maps.Marker({
        position: location,
        map: EGMap0
    });
}
</script>
<!-- <script src='<?php echo Yii::app()->baseUrl; ?>/js/markerwithlabel.js'> </script> -->