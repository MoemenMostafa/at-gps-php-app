<?php

require("protected/functions/gps.php");

//include yii config file
$config = include("protected/config/main.php");

$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
$company_id=$_GET['company_id'];
$dbHost=$config['params']['dbHost'];

$timezone =$_GET['timezone'];
$now = date('Y-m-d H:i:s');

// Opens a connection to a mySQL server
$connection=mysql_connect ($dbHost, $username, $password);
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $connection);

if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active mySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}



if ($company_id >0){
	$query = "SELECT id, name, points
                        FROM location
                        WHERE company_id =  $company_id
					 ";
	
	$result = mysql_query($query);
	if (!$result) {
	  die('Invalid query: ' . mysql_error());
	}
                
            while ($row = @mysql_fetch_assoc($result)){
                echo $row['id'].",";    
                echo $row['points'];
                    echo";";
            }
            
        }
	
	

?>