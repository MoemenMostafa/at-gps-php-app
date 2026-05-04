<?php
$conn = mysqli_connect('10.114.0.2', 'atgps', 'gps123', 'atgps');
$res = mysqli_query($conn, "SELECT * FROM vehicle_odometer_snaps WHERE odometer > 0 LIMIT 5");
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
mysqli_close($conn);
