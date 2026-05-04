<?php
set_time_limit(0);
ob_implicit_flush();
//include yii config file
$config = include("/var/www/html/atgps/protected/config/main.php");
//$config = include("../protected/config/main.php");

$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
$dbHost=$config['params']['dbHost'];

// Opens a connection to a mySQL server
$connection=mysql_connect ($dbHost, $username, $password);
if (!$connection) {
    die('Not connected : ' . mysql_error());
}
// Set the active mySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
    die ('Can\'t use db : ' . mysql_error());
}

//$yesterday = $_GET['date'];
$query = "SELECT id FROM vehicle";
$resultMain = mysql_query($query);
if ($resultMain) {
$x = 0;
    while ($row = mysql_fetch_assoc($resultMain)) {
        $result = mysql_query("ALTER TABLE vehicle_points_{$row['id']} DROP distance");
        $result = mysql_query("ALTER TABLE vehicle_points_{$row['id']} ADD distance DECIMAL(6,2)");
        echo $x++."<br>\r\n";
    };
}