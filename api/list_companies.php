<?php
		
require_once('initial.php');

//$id = $_GET['id'];

                $query = "SELECT *
                            FROM company
                            ";
					
		$result = mysql_query($query);
		if (!$result) {
		  die('Invalid query2: ' . mysql_error());
		}
		
		
		
		// Iterate through the rows, adding XML nodes for each
		while ($row = mysql_fetch_assoc($result)){
                 
                 $array[] = array(
                                'id' => $row['id'],
                                'name'=>$row['name'], 
                                'address'=>$row['address'], 
                                'country_id'=>$row['country_id'],
                                'timezone_id'=>$row['timezone_id'],
				);

		}
                $json = json_encode($array);
                echo $json;
?>

