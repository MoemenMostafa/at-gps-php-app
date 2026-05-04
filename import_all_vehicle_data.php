<?php
$dbname = 'atgps';
$dbuser = 'atgps';
$dbPassword = 'gps123';

ob_implicit_flush();


if (!mysql_connect('127.0.0.1', $dbname, $dbPassword)) {
    echo 'Could not connect to mysql';
    exit;
}

mysql_select_db($dbname) or die(mysql_error()); 

$sql = "SHOW TABLES FROM $dbname";
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

echo "Import Started for DB: $dbname\r\n";
foreach ($tables as $table) {
    $count = ++$count;
    echo "$table ($count/$total)\r\n";
    exec(" mysql -f -uatgps -p$dbPassword $dbname < /data/restore/$table.sql");
}
echo "Import Finished\r\n";


mysql_free_result($result);
?>