<?php

//gisgraphy address
/*function getAddress($lat,$long){
	if ($lat == NULL || $long == NULL || $lat > 99){return false;}
	$geoCodeURL="http://www.at-gps.com:8080/street/streetsearch?lat=$lat&lng=$long&radius=50000&to=1&format=json&indent=true";
	$geoLocURL="http://www.at-gps.com:8080/geoloc/findnearbylocation?lat=$lat&lng=$long&radius=50000&to=1&format=json&indent=true";
	$resultGeoCode = json_decode(file_get_contents($geoCodeURL), true);
	$resultGeoLoc = json_decode(file_get_contents($geoLocURL), true);
	//echo $resultGeoLoc['result'][0]['featureId'];
	
	//print_r($resultGeoLoc);
	return(($resultGeoCode['result'][0]['name']?$resultGeoCode['result'][0]['name'] : "")
		.($resultGeoCode['result'][0]['isIn']?", ".$resultGeoCode['result'][0]['isIn'] : "")
		//.($resultGeoLoc['result'][0]['asciiName']?", ".$resultGeoLoc['result'][0]['asciiName'] : "")
		.($resultGeoLoc['result'][0]['adm1Name']?", ".$resultGeoLoc['result'][0]['adm1Name']."." : "."));
}*/

//HERE address
function getAddress($lat,$long){


        // Nominatim

        // $URL = "http://52.205.102.121/reverse?format=jsonv2&lat=$lat&lon=$long&zoom=18&addressdetails=1&accept-language=ar";
        $URL = "http://10.114.0.3:8080/reverse?format=jsonv2&lat=$lat&lon=$long&zoom=18&addressdetails=1&accept-language=ar";
        $json = file_get_contents($URL);
        $result = json_decode($json, true);

        // echo "\r\n"."------------------------------------------------------------------------------"."\r\n";
        // echo "-------address----: ".$result['display_name'];
        // echo "\r\n"."------------------------------------------------------------------------------"."\r\n";
        $address = htmlspecialchars($result['display_name']);

//        //HERE API data
//        $app_id="y4k13xMn5oV8MPky3aX0";
//        $app_code="tbhFgFYAfiIRNg50dOh-9Q";
//
//        $URL= "https://reverse.geocoder.cit.api.here.com/6.2/reversegeocode.xml?app_id=$app_id&app_code=$app_code&gen=3&prox=$lat,$long,50&mode=retrieveAddresses";
//        $output = file_get_contents($URL);
//        $xml = new SimpleXMLElement($output);
//        $addressObj = $xml->Response->View->Result->Location->Address;
//
//        $addressPre[0] = $addressObj->HouseNumber;
//        $addressPre[1] = $addressObj->Street;
//        $addressPre[2] = $addressObj->District;
//        $addressPre[3] = $addressObj->City;
//        $addressPre[4] = $addressObj->County;
//        $addressPre[6] = $addressObj->AdditionalData;
//
//        if ($addressPre[3]==$addressPre[4])$addressPre[4]="";
//
//        $address ="";
//        foreach ($addressPre as $part){
//                if ($part){
//                        $address .= $part.", ";
//                }
//
//        }
//
//        $address = substr($address , 0, -2);

//        // neutrinoapi
//		$user_id = 'moemen';
//		$api_key = 'g7HOxVukKfnFN3e76aVFr282idMMkVJussA1aGSTFckE2qko';
//
//		reGetAddress:
//		$URL = "http://neutrinoapi.com/geocode-reverse?user-id=$user_id&api-key=$api_key&latitude=$lat&longitude=$long&language-code=ar";
//
//
//		$json = file_get_contents($URL);
//		$result = json_decode($json, true);
//
//		$address = $result['address'];
//
////		if ($address==""){
////			goto reGetAddress;
////		}

        return($address);
}

function getCarNumber($device_id){
	$criteria = new CDbCriteria(); $criteria->addCondition("`device_id` = '$device_id'");
	$record =  Vehicle::model()->find($criteria);
	return $record['serial'];
}




function meterToKm($meter,$round){
	$result = round($meter/1000,$round) . " km";
	return $result;
}

function reformDateTime($dateTime, $timezone = 'GMT'){
	if ($timezone == Null) $timezone = 'GMT';
        date_default_timezone_set('GMT');
	$date = DateTime::createFromFormat('YmdHis', $dateTime);
	$date->setTimezone(new DateTimeZone($timezone));
	date_default_timezone_set($timezone);
	return($date->format('Y-m-d  h:i:s a'));
}

function reformDateTimeToGPS($dateTime, $timezone = 'GMT'){
    if ($timezone == Null) $timezone = 'GMT';
    date_default_timezone_set($timezone);
    $date = DateTime::createFromFormat('Y/m/d  h:i a', $dateTime);
    $date->setTimezone(new DateTimeZone('GMT'));
    date_default_timezone_set('GMT');
    return($date->format('YmdHis'));
}

function setDateTime($dateTime, $timezone = 'GMT'){
	date_default_timezone_set('GMT');
	$date = DateTime::createFromFormat('Y-m-d  H:i:s', $dateTime);
	$date->setTimezone(new DateTimeZone($timezone));
	date_default_timezone_set($timezone);
	return($date->format('Y-m-d  h:i:s a'));
}
function setDate($dateTime, $timezone = 'GMT'){
	date_default_timezone_set('GMT');
	$date = DateTime::createFromFormat('Y-m-d  H:i:s', $dateTime);
	$date->setTimezone(new DateTimeZone($timezone));
	date_default_timezone_set($timezone);
	return($date->format('Y-m-d'));
}
function setTime($dateTime, $timezone = 'GMT'){
	date_default_timezone_set('GMT');
	$date = DateTime::createFromFormat('Y-m-d  H:i:s', $dateTime);
	$date->setTimezone(new DateTimeZone($timezone));
	date_default_timezone_set($timezone);
	return($date->format('h:i:s a'));
}

function setTimeZone($dateTime, $timezone = 'GMT'){
    date_default_timezone_set('GMT');
    $date = new DateTime(date("Y-m-d H:i",$dateTime));
    $date->setTimezone(new DateTimeZone($timezone));
    date_default_timezone_set($timezone);
    return($date->format('Y/m/d h:i a'));
}

function getFirstOfDay($dateTime){
    $date = new DateTime(date("Y-m-d H:i",$dateTime));
    return($date->format('Y/m/d 12:00 \a\m'));
}

function reformDate($dateTime, $timezone = 'GMT'){
	
	date_default_timezone_set('GMT');
	$date = DateTime::createFromFormat('YmdHis', $dateTime);
	if($date){
	$date->setTimezone(new DateTimeZone($timezone));
	date_default_timezone_set($timezone);
	return($date->format('Y-m-d'));
	}
}

function reformTime($dateTime, $timezone = 'GMT'){
	
	date_default_timezone_set('GMT');
	$date = DateTime::createFromFormat('YmdHis', $dateTime);
	if($date){
	$date->setTimezone(new DateTimeZone($timezone));
	date_default_timezone_set($timezone);
	return($date->format('h:i:s a'));
	}
}

function getStatus($dateTime, $dateTimeConn , $timezone = 'GMT', $repair = false, $trip = false){
	date_default_timezone_set('GMT');
	$date = DateTime::createFromFormat('YmdHis', $dateTime);
	$date->setTimezone(new DateTimeZone($timezone));
	date_default_timezone_set($timezone);
	
	//echo date('Y-m-d H:i:s',strtotime("-1 minutes"))."<Br/>";
	//echo $date->format('Y-m-d  H:i:s');
	
	//$date->setTimezone(new DateTimeZone('Africa/Cairo'));	
	//echo date('Y-m-d H:i:s',strtotime("-1 minutes"))."<Br/>";
	//echo $dateTimeConn;
        if ($repair){
            $sign = "url(themes/abound/img/repair.png) no-repeat center";
        }
        if ($trip){
            $sign = "url(themes/abound/img/trip-2.png) no-repeat center";
        }
        
	if (strtotime($date->format('Y-m-d  H:i:s')) >= strtotime("-1 minutes")){ 
		$data = array("style"=>"width:15px;height:15px;background:$sign lime;background-size:contain; border-radius:10px;border:1px gray solid","title"=>"Active","color"=>"lime");
	}elseif (strtotime(date($dateTimeConn)) >= strtotime("-90 seconds")){
		$data = array("style"=>"width:15px;height:15px;background:$sign blue;background-size:contain; border-radius:10px;border:1px gray solid","title"=>"Connected","color"=>"blue");
	}else{
		$data = array("style"=>"width:15px;height:15px;background:$sign gray;background-size:contain; border-radius:10px;border:1px gray solid","title"=>"Offline","color"=>"gray");
	}
	return($data);
}

function getRepairStatus($vehicleId){
        $now= date('Y-m-d');
    	$criteria = new CDbCriteria(); 
        $criteria->addCondition("`vehicle_id` = '$vehicleId' AND end_date = '0000-00-00' OR `vehicle_id` = '$vehicleId' AND end_date > '$now'");
	$record =  Repairs::model()->find($criteria);
	//echo var_dump($record);
        if($record){
            return true;
        }else{
            return false;
        }
}

function getCarMapStatus($dateTimeConn){ 
	date_default_timezone_set("GMT");
	$data = "online";
	if (strtotime(date($dateTimeConn)) < strtotime("-3 minutes")){
		$data = "offline";
	}
	return($data);
}

function ignitionStat($input){
	if ($input == 0)return "<text>Off</text>";
	if ($input == 1 || $input == 2 /*for IntelliTrac X8*/)return "<text style='color:rgb(182, 0, 0);font-weight:bold'>On</text>";
}

function ignitionStatBol($input){
	if ($input == 0)return 0;
	if ($input == 1 || $input == 2 /*for IntelliTrac X8*/)return 1;
}

function calculateDistance($lat1, $lng1, $lat2, $lng2, $miles = false)
{
    $pi80 = M_PI / 180;
    $lat1 *= $pi80;
    $lng1 *= $pi80;
    $lat2 *= $pi80;
    $lng2 *= $pi80;

    $r = 6372.797; // mean radius of Earth in km
    $dlat = $lat2 - $lat1;
    $dlng = $lng2 - $lng1;
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c;

    return ($miles ? ($km * 0.621371192) : $km);
}

function debug_to_console($title, $data) {
	$output = $data;
	if (is_array($output))
		$output = implode(',', $output);

	echo "<script>console.log('$title','$output');</script>";
}

class pointLocation {
    var $pointOnVertex = true; // Check if the point sits exactly on one of the vertices

    function pointLocation() {
    }
    
    
    function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;
        
        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array(); 
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }
        
        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }
        
        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);
    
        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        // If the number of edges we passed through is even, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return 1;
        } else {
            return 0;
        }
    }

    
    
    function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
    
    }
        
    
    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
		// y = Latitude, x = Longitude
        return array("y" => $coordinates[0], "x" => $coordinates[1]);
    }



}





?>