<?php

require_once "connection.php";


$zip = 79907;

$q = "SELECT ZoneGround FROM ZiptoZone WHERE LEFT($zip, 3) BETWEEN LowZip and HighZip;";
$result2 = $conn->query($q);
$rArray = mysqli_fetch_assoc($result2);
$zone = $rArray['ZoneGround'];
echo $zone;
