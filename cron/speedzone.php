<?php
header( 'Content-type: text/html; charset=utf-8' );
// Set timezone
	date_default_timezone_set('UTC');
 
	// Start date
	$date = '20151213';
	// End date
	$end_date = '20160213';
 
	while (strtotime($date) <= strtotime($end_date)) {
		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, "http://www.at-gps.com/cron/vehicleZoneSpeed.php?date=$date");
		curl_setopt($ch, CURLOPT_HEADER, 0);
echo "(";
		// grab URL and pass it to the browser
		curl_exec($ch);

		// close cURL resource, and free up system resources
		curl_close($ch);
	
echo " - $date)\n";
    flush();
    ob_flush();
		$date = date ("Ymd", strtotime("+1 day", strtotime($date)));
	}



?>
