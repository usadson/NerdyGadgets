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
  `OrderInfo` LONGTEXT NOT NULL,
  PRIMARY KEY (`C_OrderID`));



 */

/*Hier wordt de persoons informatie voor de betaling opgeslagen */
$Order['Firstname'] = $_POST['firstName'];
$Order['Lastname'] = $_POST['lastName'];
$Order['Address'] = $_POST['address'];
$Order['State'] = $_POST['state'];
$Order['Country'] = $_POST['country'];
$Order['PostalCode'] = $_POST['address-2'];
$Order['payment'] = $_POST['payment'];

/* Hier wordt deze informatie klaar gemaakt voor de database */
$SerieelOrder =  serialize($Order);


#$NietSerieelOrder =  unserialize($SerieelOrder);
#print_r($Order);
#print('<br>' . $SerieelOrder . '<br>');
#print_r ($NietSerieelOrder);




/* ALS de mand leeg is gaat het script niet door */
if($_SESSION['mand'] != []) {

    /* Haalt het hoogst mogelijke orderId op en voegt er 1 aan toe zodat dit het nieuwe orderID kan worden */
    $sqlID = mysqli_query($Connection, "SELECT MAX(C_OrderID) AS ID FROM customer_orders LIMIT 1");
    while ($row = mysqli_fetch_assoc($sqlID)) {
        $_SESSION['OrderID'] = ($row['ID'] + 1);
    }

#print $NewID;

    /* De standaard user voor niet ingelogden is 4000*/
    $user = 4000;

    /* Als de user ingelogd is word $user gezet naar hun UserID */
    if (isset($_SESSION['UserID'])) {
        $user = $_SESSION['UserID'];
    }

    /* Hier wordt de shoppingcart verwerkt en geleegd */
    $Ordered = $_SESSION['mand'];
    $serieel = serialize($Ordered);


    /* Hier wordt de informatie in de database geplaatst */
    $sqlordertodatabase = ("INSERT INTO customer_orders VALUES (" . $_SESSION['OrderID'] . ", '" . $serieel . "', " . $user . ", '" . $SerieelOrder . "')");
    #PREPARED STATEMENT
    mysqli_query($Connection, $sqlordertodatabase);
}

/*  Hier worden de gekochte producten nogmaals opgehaald*/
$sqlItems = mysqli_query($Connection, "SELECT products FROM customer_orders WHERE C_OrderID = '" . $_SESSION['OrderID'] . "' LIMIT 1");
#PREPARED STATEMENT

/* Hier worden de producten van database informatie(string) naar array gezet*/
while($row = mysqli_fetch_assoc($sqlItems)) {
    $BoughtProducts = unserialize($row['products']);
}
#print_r($BoughtProducts);

/* $totaalprijs start op 0 om dat hier op opgeteld moet worden */
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
<!-- Hieronder staan de gegevens van de betaling -->
    <div style="border-bottom: black;">
    <h1 align="left" style="padding-left: 2%;">OrderInformatie</h1>
    <h2 align="left" style="padding-left: 2%;">Gegevens</h2>
    <p align="left" style="padding-left: 2%;">
    Voornaam:    <?php print ($_POST['firstName']); ?><br>
    Achternaam:  <?php print ($_POST['lastName']); ?><br>
    Adress:      <?php print ($_POST['address'] . ", " . $_POST['state'] . ", " . $_POST['country']); ?><br>
    Postcode:    <?php print ($_POST['address-2']); ?>
    </p>
    <h2 align="left" style="padding-left: 2%;">Producten</h2>
        <?php
        /* Hier worden de producten individueel vertaald naar foto's , namen en prijzen (Vergelijkbaar met cart.php) */
        foreach($BoughtProducts as $productid => $aantal) {
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

            $totaalprijs = $totaalprijs + ($infoproduct["SellPrice"] * $aantal);
            $totaalprijsproduct = ($infoproduct["SellPrice"] * $aantal);


            $SQLstock = "
                    SELECT QuantityOnHand
                    FROM stockitemholdings
                    WHERE StockItemID =  ?";
            $Statement2 = mysqli_prepare($Connection, $SQLstock);

            mysqli_stmt_bind_param($Statement2, "i", $productid);
            mysqli_stmt_execute($Statement2);
            $stock = mysqli_stmt_get_result($Statement2);
            $stock = mysqli_fetch_all($stock, MYSQLI_ASSOC);
            $stock = $stock[0];
            $stock = $stock['QuantityOnHand'];
            $newStock = ($stock - $aantal);
            print ($stock . " | " . $newStock);


            #print $stock;
            print("
                    
                        <img src='https://media.tarkett-image.com/large/TH_25121916_25131916_25126916_25136916_001.jpg' width='100%' height='1px'>
                            <img align ='left' class='media-object' src= '$img' style='width: 10%;'>
                            
                                <h3 align='right' class='media-heading' style='color: blue;'>" . $infoproduct["StockItemName"] . "</h3>
                                
                                <h4 align='right' style='color: green;'>Prijs $aantal * " . round($infoproduct["SellPrice"], 2) . " = (" . round($totaalprijsproduct, 2) . ")</h4>
                            
                        
                    ");
            if ($_SESSION['mand'] != []) {
                mysqli_query($Connection,"
                    UPDATE stockitemholdings
                    SET QuantityOnHand = " . $newStock . "
                    WHERE StockItemID =  " . $productid . " ");
            }
        }

        ?>
    </div>
</body>
</html>
<?php
$_SESSION['mand'] = [];
include __DIR__ . "/footer.php";
?>