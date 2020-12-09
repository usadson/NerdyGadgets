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
$sqlID = mysqli_query($Connection, "SELECT MAX(C_OrderID) AS ID FROM consumer_orders LIMIT 1");
while($row = mysqli_fetch_assoc($sqlID)) {
    $NewID = ($row['ID'] + 1);
}
#print $NewID;
$user = 4000;
if(isset($_SESSION['UserID'])) {
    $user = $_SESSION['UserID'];
}

$Ordered = $_SESSION['mand'];
$serieel = serialize($Ordered);
$_SESSION['mand'] = [];


$sqlordertodatabase = ("INSERT INTO consumer_orders
VALUES (" . $NewID . ", '" . $serieel . "', " . $user . ")");
    mysqli_query($Connection, $sqlordertodatabase);

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
<div style="background-color: white; color: black;width: 70%"

    </div>
</body>
</html>
<?php
include __DIR__ . "/footer.php";
?>