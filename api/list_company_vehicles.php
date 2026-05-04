<?php
require_once('initial.php');

$id = $_GET['id'];

                $query = "SELECT v.*, vt.type_en, vt.type_ar
                            FROM vehicle as v
                            LEFT JOIN vehicle_type as vt on vt.id = v.vehicle_type_id
                            WHERE v.company_id=$id
                            Order By v.serial+0, v.serial+0 <>0 DESC, v.serial";
					
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query2: ' . mysql_error());
		}
		
		
		
		// Iterate through the rows, adding XML nodes for each
		while ($row = mysql_fetch_assoc($result)){
                 
                 $array[] = array(
                                'id' => $row['id'],
                                'device_id' => $row['device_id'],
                                'serial' => $row['serial'],
                                'name'=>$row['name'], 
                                'serial' => $row['serial'],
                                'model'=>$row['model'], 
                                'vehicle_type_en'=>$row['type_en'],
                                'vehicle_type_ar'=>$row['type_ar'],
                                'odometer'=>round($row['odometer']/1000),
				);

		}
                $json = json_encode($array);
                echo $json;

?>

