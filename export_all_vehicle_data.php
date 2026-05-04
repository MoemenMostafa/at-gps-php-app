<?php
$config = include("/var/www/html/atgps/protected/config/main.php");


$username=$config['components']['db']['username'];
$password=$config['components']['db']['password'];
$database=$config['components']['db']['username'];
$dbHost=$config['params']['dbHost'];

// Opens a connection to a mySQL server
$connection=mysql_connect ($dbHost, $username, $password);

ob_implicit_flush();


if (!$connection) {
    echo 'Could not connect to mysql';
    exit;
}

mysql_select_db($database) or die(mysql_error()); 

$sql = "SHOW TABLES FROM $database";
$result = mysql_query($sql);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

$count = 0;
$total = 0;
$tables = array();

while ($row = mysql_fetch_row($result)) {
    if (substr($row[0],0,15) == "vehicle_points_"){
        $total = ++$total;
        $tables[] = $row[0];
    }
}

// echo "$total\r\n";
foreach ($tables as $table) {
    $count = ++$count;
    echo "$table ($count/$total)\r\n";
    exec(" mysqldump -uatgps -p$password $database $table --no-create-info  > /data/backup/31.12.19/$database.$table.sql");
}
echo "Export Finished";


mysql_free_result($result);
?>