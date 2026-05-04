<?php
$conn = mysqli_connect('10.114.0.2', 'atgps', 'gps123', 'atgps');
$res = mysqli_query($conn, "SELECT date FROM alert_overspeed WHERE date != '0000-00-00' LIMIT 5");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['date'] . "\n";
}
mysqli_close($conn);
