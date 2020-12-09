<?php
include __DIR__ . "/header.php";
include_once "connect.php";
global $Connection;
/*
   CREATE TABLE `nerdygadgets`.`consumer_orders` (
  `C_OrderID` INT NOT NULL,
  `order` LONGTEXT NOT NULL,
  `PersonID` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idconsumer_orders`));
 */
if(!isset($_SESSION['Done'])) {
    $sqlID = mysqli_query($Connection, "SELECT MAX(C_OrderID) AS ID FROM consumer_orders LIMIT 1");
    while ($row = mysqli_fetch_assoc($sqlID)) {
        $_SESSION['OrderID'] = ($row['ID'] + 1);
    }

#print $NewID;

    $user = 4000;
    if (isset($_SESSION['UserID'])) {
        $user = $_SESSION['UserID'];
    }

    $Ordered = $_SESSION['mand'];
    $serieel = serialize($Ordered);
    $_SESSION['mand'] = [];


    $sqlordertodatabase = ("INSERT INTO consumer_orders VALUES (" . $_SESSION['OrderID'] . ", '" . $serieel . "', " . $user . ")");
    mysqli_query($Connection, $sqlordertodatabase);
    $_SESSION['Done'] = TRUE;
}
$sqlItems = mysqli_query($Connection, "SELECT products FROM consumer_orders WHERE C_OrderID = '" . $_SESSION['OrderID'] . "' LIMIT 1");

while($row = mysqli_fetch_assoc($sqlItems)) {
    $BoughtProducts = unserialize($row['products']);
}
print_r($BoughtProducts);
?>
<style>
    h1{
        color: black;
    }
</style>
<html>
<head>
    <title>Order bevestiging</title>
<body>
    <div align="center">

<h1>Betaling is gelukt!<br> Bedankt voor uw aankoop!</h1>
<div style="background-color: white; color: black;width: 70%">
    <h1 align="left" style="padding-left: 2%;">OrderInformatie</h1>
    <h2 align="left" style="padding-left: 2%;">Gegevens</h2>
    <p align="left" style="padding-left: 2%;">
    Voornaam:    XXXX<br>
    Achternaam:  XXXX<br>
    Adress:      XXXX<br>
    Postcode:    XXXX
    </p>
    </div>
</body>
</html>
<?php

include __DIR__ . "/footer.php";
?>