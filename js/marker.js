// JavaScript Document

var check;
var myMarkers;
var setFocusOnRID = false;
var traceMarkerId = false;
var tracePoint = false;
var infowindow;
var Polygon = [];
var editableLandmarks = false;
var landmark = {};
var landmarks = {};
var getLandmarks;

function markerManager(companyId,userId) {
  
  if (check!=true){
	downloadUrl("updateMarkers.php?id="+companyId+"&userId="+userId, function(data) {
		//console.log('userId:'+userId);
		xml = data.responseXML;
		markers = xml.documentElement.getElementsByTagName("marker");
		myMarkers = new Array();
		infowindow = new Array();
                //mc = new MarkerClusterer(EGMap0);
                for (var i = 0; i < markers.length; i++) {
				myMarkers[markers[i].getAttribute("device_id")] = addMarker(EGMap0, markers[i]);
				bounds.extend(myMarkers[markers[i].getAttribute("device_id")].getPosition());
		
		}
		
		
                
	});
	
	check = true;
	//console.log(check);
  }else{updateMarkers(companyId,userId);}
  
}

function addMarker(map, data) {
	//create the markers
	  var name = data.getAttribute("device_id");
	  var vehicle_number = vehicleNumber(data);
	  var point = new google.maps.LatLng(
		  parseFloat(data.getAttribute("latitude")),
		  parseFloat(data.getAttribute("longitude")));
	  html = "<b>" + name + "</b> <br/>";
	  var direction = data.getAttribute("direction");
	  var directionMod = directionModified(direction);
	  var speed = data.getAttribute("speed");
	  var status = data.getAttribute("status");
          var ignition = data.getAttribute("ignition");
	  var image = getIcon(directionMod,speed,status,ignition);
	  
	  
	  var marker = new MarkerWithLabel({
		map: map,
		position: point,
		//icon: 'http://maps.google.com/mapfiles/dir_'+directionMod+'.png'
		icon: image,
		labelContent: vehicle_number,
        labelAnchor: new google.maps.Point(12.5, -20),
        labelClass: "labels", // the CSS class for the label
        labelStyle: {opacity: 0.75}
	  });
		/*//create the info windows
		var content = document.createElement("DIV");
		var title = document.createElement("DIV");
		title.innerHTML = infoWindowContent(data);
		content.appendChild(title);
	   
	   infowindow[name] = new google.maps.InfoWindow({
			content: content
		});*/
	
		// set focous on marker click
		google.maps.event.addListener(marker, "click", function() {
			//infowindow[name].open(map, marker);
			$("#vehicleSelector").val(name);
				setMarkerFocus(name,13)
		});
		// set focous on marker click
		google.maps.event.addListener(marker, "dblclick", function() {
			//infowindow[name].open(map, marker);
			$("#vehicleSelector").val(name);
				setMarkerFocus(name,16)
		});
                //mc.addMarker(marker);
	return marker;    
}



function updateMarkers(companyId,userId) {
  downloadUrl("updateMarkers.php?id="+companyId+"&userId="+userId, function(data) {
	var xml = data.responseXML;
	markers = xml.documentElement.getElementsByTagName("marker");
	//var code='<table>';
	
		for (var i = 0; i < markers.length; i++) {

				var device_id = markers[i].getAttribute("device_id");
				var latitude = markers[i].getAttribute("latitude");
				var longitude = markers[i].getAttribute("longitude");
				var speed = markers[i].getAttribute("speed");
				var status = markers[i].getAttribute("status");
                                var ignition = markers[i].getAttribute("ignition");
				changeMarkerPosition(myMarkers[markers[i].getAttribute("device_id")], latitude, longitude, markers[i].getAttribute("direction"),speed,status,ignition);
                                /*infowindow[device_id].setContent(
							infoWindowContent(markers[i])
				)*/
                                //if (setFocusOnRID){myMarkers[markers[i].getAttribute("device_id")].setVisible(false);}else{myMarkers[markers[i].getAttribute("device_id")].setVisible(true);}
				if (setFocusOnRID==markers[i].getAttribute("device_id")){focusWithoutZoom(setFocusOnRID);getVehicleInfo(setFocusOnRID);}
				if (traceMarkerId==markers[i].getAttribute("device_id")){setMarkerTrace(traceMarkerId);}
                                
                                
				//code+='<tr><td>'+device_id+'</td><td>'+latitude+'</td><td>'+longitude+'</td><td>'+speed+'</td><td>'+status+'</td></tr>';
		}	
		//code+='</table>'
	//$('#manualTable').html(code);

  });
  		//if (setFocusOnRID){focusWithoutZoom(setFocusOnRID);getVehicleInfo(setFocusOnRID);}
		//if (traceMarkerId){setMarkerTrace(traceMarkerId);}	
}



function getVehicleInfo(device_id) {

    // fire off the request to /form.php
    var request = $.ajax({
        url: "index.php?r=map/AjaxGetVehicleInfo",
        type: "post",
        data: 'deviceID='+device_id
    });

    // callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // log a message to the console
        //console.log("Hooray, it worked!");
		$('#vehicleInfo').html(response);
    });

    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // log the error to the console
        console.error(
            "The following error occured: "+
            textStatus, errorThrown
        );
    });



		if (setFocusOnRID){focusWithoutZoom(setFocusOnRID);}
		if (traceMarkerId){setMarkerTrace(traceMarkerId);}
  
}

function  vehicleNumber(data){
	if (data.getAttribute("vehicle_number") == ""){
		   vehicle_number = "N/A";
		  }else{
		    vehicle_number = data.getAttribute("vehicle_number");
		  }
		  
		  return vehicle_number;
	
}


function changeMarkerPosition(marker,lat,long,direction,speed,status,ignition) {
	//var latlng = new google.maps.LatLng(lat, long);
	//console.log(marker);
	marker.setPosition(new google.maps.LatLng(lat,long));
	var directionMod = directionModified(direction);
	marker.setIcon(getIcon(directionMod,speed,status,ignition));
	
}

function directionModified(direction){
		var	directionMod = Math.round(direction/10)+1;
	  if (directionMod >= 37) directionMod = 1;	
	  return directionMod;
	
}

function getIcon(directionMod,speed,status,ignition){
        if(speed==0 || ignition==0){var color='yellow';var Color='Yellow';}
	if(speed>0 && ignition>0){var color='green';var Color='Green';}
	if(speed>90){var color='red';var Color='Red';}
	if(status=='offline'){var color='gray';var Color='Gray';}
	icon = new google.maps.MarkerImage('images/car/'+color+'/'+Color+'_car_'+directionMod+'.png',
        new google.maps.Size(42, 42),
        new google.maps.Point(0,0),
        new google.maps.Point(21, 21)
	  );	
	  return icon;
}

function changeSelector(device_id){
		$("#vehicleSelector").val(device_id);
		setMarkerFocus(device_id,13);
}

function setMarkerFocus(device_id,zoom){
	setFocusOnRID = device_id;
	getVehicleInfo(setFocusOnRID);
	EGMap0.panTo(myMarkers[device_id].getPosition());
        
        //Hide all markers but this
        for (var deviceId in myMarkers) {
            if (myMarkers.hasOwnProperty(deviceId)) { 
              myMarkers[deviceId].setVisible(false);
            }
        }
        myMarkers[device_id].setVisible(true);
        //
        
	if (zoom > EGMap0.getZoom()){
	//EGMap0.setZoom(zoom);
        smoothZoom(EGMap0, zoom, EGMap0.getZoom()); 
	}
        $('#controlButtons').attr('style','display:block');
	$('#lock').attr('style','display:none');
	$('#unlock').attr('style','display:block');
	$('#trace').attr('style','display:block');
}

function loseMarkerFocus(){
	setFocusOnRID = false;
        //Show all markers but this
        for (var deviceId in myMarkers) {
            if (myMarkers.hasOwnProperty(deviceId)) { 
              myMarkers[deviceId].setVisible(true);
            }
        }
}

function focusWithoutZoom(device_id){
	setFocusOnRID = device_id;
	EGMap0.panTo(myMarkers[device_id].getPosition());
}

function showAllMarkers(){
	setFocusOnRID = false;
	EGMap0.fitBounds(bounds);
	var zoom = EGMap0.getZoom();
	EGMap0.setZoom(zoom > 11 ? 11 : zoom);
	getVehicleInfo();
        $('#controlButtons').attr('style','display:none');
        //Show all markers but this
        for (var deviceId in myMarkers) {
            if (myMarkers.hasOwnProperty(deviceId)) { 
              myMarkers[deviceId].setVisible(true);
            }
        }
}


function setMarkerTrace(device_id){
	if (!tracePoint){
		traceMarkerId = device_id;
		tracePoint = myMarkers[device_id].getPosition();
	}else{
		 var traceCoordinates = [
			 tracePoint,
			 myMarkers[device_id].getPosition(),
		 ];
		 var tracePath = new google.maps.Polyline({
			path: traceCoordinates,
			strokeColor: "#FF0000",
			strokeOpacity: 1.0,
			strokeWeight: 2
		 });
		 tracePath.setMap(EGMap0);
		 tracePoint = myMarkers[device_id].getPosition();
	}
}

function stopTracing(){
		traceMarkerId = false;
		tracePoint = false;
}





function downloadUrl(url, callback) {
  	var request = window.ActiveXObject ?
	  new ActiveXObject('Microsoft.XMLHTTP') :
	  new XMLHttpRequest;

  request.onreadystatechange = function() {
	if (request.readyState == 4) {
	  request.onreadystatechange = doNothing;
	  callback(request, request.status);
	}
  };

  request.open('GET', url, true);
  request.send(null);
}

function infoWindowContent(data){
	
		  
	var vehicle_number = vehicleNumber(data);
	
	return 	"<table><tr><td>Vehicle #: </td><td>"+vehicle_number		+"</td></tr>"+
			"<tr><td>Date & Time: </td><td>"+data.getAttribute("datetime")		+"</td></tr>"+
			"<tr><td>Speed: </td><td>"+data.getAttribute("speed")+" Km/h</td></tr>"+
			"<tr><td>Address: </td><td>"+data.getAttribute("address")+"</td></tr>"+
			"<tr><td>Driver: </td><td>"+data.getAttribute("driver_name")+
			"</table>"
			;
							
	
}

// the smooth zoom function
function smoothZoom (map, max, cnt) {
    if (cnt >= max) {
            return;
        }
    else {
        z = google.maps.event.addListener(map, 'zoom_changed', function(event){
            google.maps.event.removeListener(z);
            self.smoothZoom(map, max, cnt + 1);
        });
        setTimeout(function(){map.setZoom(cnt)}, 80); // 80ms is what I found to work well on my system -- it might not work well on all systems
    }
}  

function doNothing() {}


function setLocationFocus(locationId){
   //console.log("locationId: "+ locationId);
   google.maps.Polygon.prototype.getBounds = function() {
    var bounds = new google.maps.LatLngBounds();
    var paths = this.getPaths();
    var path;        
    for (var i = 0; i < paths.getLength(); i++) {
        path = paths.getAt(i);
        for (var ii = 0; ii < path.getLength(); ii++) {
            bounds.extend(path.getAt(ii));
        }
    }
    return bounds;
}
   EGMap0.fitBounds(Polygon[locationId].getBounds());

}

function getVehiclesInLocation(company_id,location_id){
   if (!company_id && !location_id){
        $( "#vehiclesInLocationSum" ).html("");
        $( "#vehiclesInLocationList" ).html("");
   }
    $.getJSON( "getVehiclesInLocation.php?company_id="+company_id+"&location_id="+location_id, function( data ) {
    var items = [];
    i = 0;
    $.each( data, function( key, val ) {
      items.push( "<li id='" + val + "'>" + key + "</li>" );
      i++;
    });
    $( "#vehiclesInLocationSum" ).html("");
    $( "#vehiclesInLocationList" ).html("");
    $( "#vehiclesInLocationSum" ).html(i+" Vehicle(s)");
    $( "<ul/>", {
      "class": "my-new-list",
      html: items.join( "" )
    }).appendTo( "#vehiclesInLocationList" );
  });
}

function showLocations(companyId){
    var allLocationsPoints;
    
        // fire off the request to /form.php
    var request = $.ajax({
        url: "getLocations.php",
        type: "get",
        data: 'company_id='+companyId
    });

    // callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // log a message to the console
        //console.log("Hooray, it worked!");
		allLocationsPoints = response;
                allLocationsPoints = allLocationsPoints.substring(0, allLocationsPoints.length-1);
                locationPoints = allLocationsPoints.split(";");
                
                
                        
            for (var z = 0, len = locationPoints.length; z < len; z++) {
                        
                        //console.log("locations["+z+"]: "+locationPoints[z]);
                        locationPoints[z] = locationPoints[z].replace(/\)/g,"");
			locationPoints[z] = locationPoints[z].replace(/\(/g,"");
			
			var n=locationPoints[z].split(",");
			var editablePolygonPoints = [];
			var x=0;
                        locationId = n['0'];
			for (var i =1; i < n.length ; i++) {
				editablePolygonPoints[x] = new google.maps.LatLng(n[i],n[++i]);
				x++;
			 }
			  Polygon[locationId] = new google.maps.Polygon({
				paths: editablePolygonPoints,
				editable:false
			  });
			 
			 var bounds = new google.maps.LatLngBounds();
			 
			 for (var i = 0; i < editablePolygonPoints.length; i++) {
				  bounds.extend(editablePolygonPoints[i]);
			}
			

			
			// Check if the editablePolygonPoints are loaded to fit map to bounds
			if(editablePolygonPoints.length>1){
				Polygon[locationId].setMap(EGMap0);
				//EGMap0.fitBounds(bounds);
			}
                        
            }
            $('#locationsButton').html('Hide Locations');
            showLocationFunction = $('#locationsButton').attr("onclick");
            $('#locationsButton').attr("onclick","hideLocations()");
            $('.locationOverlay').css("display", "block");
            //Polygon['2'].setMap(null);
    });

    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // log the error to the console
        console.error(
            "The following error occured: "+
            textStatus, errorThrown
        );
    });
    //Trim last chracter ";"
    
}

function getLandmarks(){
	for (var key in landmark){
		landmark[key].setMap(null);
	}
	$.getJSON("?r=landmarks/get",function(result){
			var landmarks = result;

			for (var i=0; i< landmarks.length ;i++){
				//console.log(landmarks[i]);
				var myLatLng = {lat: parseFloat(landmarks[i].lat), lng: parseFloat(landmarks[i].long)};

				landmark[i] = new google.maps.Marker({
					position: myLatLng,
					map: EGMap0,
					title: landmarks[i].name,
					icon: 'images/icons/landmarks/LandMark'+landmarks[i].icon+'.png',
					id: landmarks[i].id,
					icon_id: landmarks[i].icon
				});
				google.maps.event.addListener(landmark[i],'click',function() {
					if (editableLandmarks){
						$("#Landmarks_lat").val(this.position.lat());
						$("#Landmarks_long").val(this.position.lng());
						$("#Landmarks_name").val(this.title);
						$("#Landmarks_icon").val(this.icon_id);
						$("#Landmarks_icon").trigger("change");
						$("#Landmarks_id").val(this.id);
						$("#LandmarksModalLabel").html("Edit Landmark");
						$("#LandmarksModal").modal("show");
					}
				});
			}
		}
	)
	setTimeout(()=>google.maps.event.addListener(EGMap0, 'zoom_changed', function(event) {
		var zoom = EGMap0.getZoom();
		//console.log("landmark", zoom);
		for (key in landmark) {
			landmark[key].setVisible(zoom >= 9);
		}
	}),500);
}
$(document).ready(function() {
	setTimeout(function () {
		getLandmarks()
	},2000);
});

function hideLocations(){
    for (var prop in Polygon) {
        if (Polygon.hasOwnProperty(prop)) { 
          Polygon[prop].setMap(null);
        }
      }
    $('#locationsButton').html('Show Locations');
    $('#locationsButton').attr("onclick",showLocationFunction);
    $('.locationOverlay').css("display", "none");
}

function editLandmarks(){
	editableLandmarks = true;
	$('#landmarksButton').html('Stop Editing Landmarks');
	$('#landmarksButton').attr("onclick","stopEditLandmarks()");
}

function stopEditLandmarks(){
	editableLandmarks = false;
	$('#landmarksButton').html('Edit Landmarks');
	$('#landmarksButton').attr("onclick","editLandmarks()");
}