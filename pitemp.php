<?php
include_once "connect.php";


$SQLID = mysqli_query($Connection, "
                    SELECT MAX(ColdRoomTemperatureID) AS ID
                    FROM coldroomtemperatures");
while ($row = mysqli_fetch_assoc($SQLID)) {
    $ID = ($row['ID'] + 1);
}
#print $ID;

$temperatuur = $_POST['temp'];
$deviceID = $_POST['ID'];
$Date = date("Y-m-d H:i:s");
$DateValidTo = "9999-12-31 23:59:59";
#print $Date;
mysqli_query($Connection, "INSERT INTO coldroomtemperatures (ColdRoomTemperatureID, ColdRoomSensorNumber, RecordedWhen, Temperature, ValidFrom, ValidTo) VALUES (" .  $ID . ", " . $deviceID . ",  '" . $Date . "', " . $temperatuur . ", '" . $Date . "', '" . $DateValidTo . "') ");
?>