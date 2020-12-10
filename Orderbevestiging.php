<?php
include __DIR__ . "/header.php";
include_once "connect.php";
include __DIR__ . "/functions.php";
global $Connection;
/*
   CREATE TABLE `nerdygadgets`.`customer_orders` (
  `C_OrderID` INT NOT NULL,
  `products` LONGTEXT NOT NULL,
  `PersonID` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`C_OrderID`));



 */
if(!isset($_SESSION['Done'])) {
    $sqlID = mysqli_query($Connection, "SELECT MAX(C_OrderID) AS ID FROM customer_orders LIMIT 1");
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


    $sqlordertodatabase = ("INSERT INTO customer_orders VALUES (" . $_SESSION['OrderID'] . ", '" . $serieel . "', " . $user . ")");
    mysqli_query($Connection, $sqlordertodatabase);
    $_SESSION['Done'] = TRUE;
}
$sqlItems = mysqli_query($Connection, "SELECT products FROM customer_orders WHERE C_OrderID = '" . $_SESSION['OrderID'] . "' LIMIT 1");

while($row = mysqli_fetch_assoc($sqlItems)) {
    $BoughtProducts = unserialize($row['products']);
}
print_r($BoughtProducts);
$totaalprijs = 0;
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

    <div style="border-bottom: black;">
    <h1 align="left" style="padding-left: 2%;">OrderInformatie</h1>
    <h2 align="left" style="padding-left: 2%;">Gegevens</h2>
    <p align="left" style="padding-left: 2%;">
    Voornaam:    XXXX<br>
    Achternaam:  XXXX<br>
    Adress:      XXXX<br>
    Postcode:    XXXX
    </p>
    <h2 align="left" style="padding-left: 2%;">Producten</h2>
        <?php
        foreach($BoughtProducts as $productid => $aantal){
            $infoproduct = getProductInfo($productid);
            $totaalprijsproduct = 0;

            $Query = "
                    SELECT ImagePath
                    FROM stockitemimages 
                    WHERE StockItemID = ?";

            $Statement = mysqli_prepare($Connection, $Query);

            mysqli_stmt_bind_param($Statement, "i", $productid);
            mysqli_stmt_execute($Statement);
            $R = mysqli_stmt_get_result($Statement);
            $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

            if ($R) {
                $img = "Public/StockItemIMG/" . $R[0]['ImagePath'];
                #print($img);
            } else {

                $img = "Public/StockGroupIMG/" . $infoproduct['BackupImagePath'];
                #print ($img);
            }

            $totaalprijs = $totaalprijs + ($infoproduct["SellPrice"]* $aantal);
            $totaalprijsproduct = ($infoproduct["SellPrice"]* $aantal);

            print("
                    
                        <img src='https://media.tarkett-image.com/large/TH_25121916_25131916_25126916_25136916_001.jpg' width='100%' height='1px'>
                            <img align ='left' class='media-object' src= '$img' style='width: 10%;'>
                            
                                <h3 align='right' class='media-heading' style='color: blue;'>" . $infoproduct["StockItemName"] . "</h3>
                                
                                <h4 align='right' style='color: green;'>Prijs $aantal * " . $infoproduct["SellPrice"] . " = (" . $totaalprijsproduct . ")</h4>
                            
                        
                    ");

        }

        ?>
    </div>
</body>
</html>
<?php

include __DIR__ . "/footer.php";
?>