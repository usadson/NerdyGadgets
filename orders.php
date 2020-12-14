<?php
include __DIR__ . "/header.php";
include_once "connect.php";
include __DIR__ . "/functions.php";
global $Connection;
?>
<!-- Hier wordt het visueele deel van de accordion gemaakt-->
    <style>
        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active, .accordion:hover {
            background-color: #ccc;
        }

        .panel {
            padding: 0 18px;
            display: none;
            background-color: white;
            overflow: hidden;
        }
    </style>

<?php
/* Dit mag alleen uitgevoerd als je ingelog bent */
if(isset($_SESSION['UserID'])){


    ?>





    <div align="center" width="80%" style="background-color: white"><br><br><h1>Uw bestellingen</h1><br><br>
<?php





/* NIEUWE CODE */
$sqlmyorders = mysqli_query($Connection, "SELECT C_OrderID FROM customer_orders WHERE PersonID = " . $_SESSION['UserID'] . " ");

foreach($sqlmyorders AS $orderIDarray){
#print_r($orderID);
$orderID = $orderIDarray['C_OrderID'];
$sqlSendTo = mysqli_query($Connection, "SELECT OrderInfo FROM customer_orders WHERE C_OrderID = '" . $orderID . "' LIMIT 1");
    while($row = mysqli_fetch_assoc($sqlSendTo)) {
        $OrderedBy = unserialize($row['OrderInfo']);
    }

?>
    <button class="accordion">Ordernummer: <?php print($orderID); ?></button>
    <div class="panel" style="padding-top: 1%; padding-left: 2%; padding-right: 2%;">
        <div align="left">
        <h3 align="left">Verzonden naar:</h3>
        <div style="background-color: lightgray;width: 20%;">
        <p align="left" style="padding-left: 8px">
            Voornaam:    <?php print $OrderedBy['Firstname'] ?><br>
            Achternaam:  <?php print $OrderedBy['Lastname'] ?><br>
            Adress:      <?php print ($OrderedBy['Address'] . ", " . $OrderedBy['State'] . ", " . $OrderedBy['Country']) ?><br>
            Postcode:    <?php print $OrderedBy['PostalCode'] ?><br>
            Betaalmethode: <?php print $OrderedBy['payment'] ?>
        </p>
        </div>
        </div>
        <img src='https://media.tarkett-image.com/large/TH_25121916_25131916_25126916_25136916_001.jpg' width='100%' height='1px'>

        <?php

    $sqlItems = mysqli_query($Connection, "SELECT products FROM customer_orders WHERE C_OrderID = '" . $orderID . "' LIMIT 1");

    while($row = mysqli_fetch_assoc($sqlItems)) {

        $producten = unserialize($row['products']);
    }
    #print_r($producten);

    $totaalprijs = 0;

/* CART code*/
    foreach($producten as $productid => $aantal){
        $infoproduct = getProductInfo($productid);
        $totaalprijsproduct = 0;
        $aantalproduct = $producten[$productid];
        #print ("<h1>" . $aantalproduct . "</h1>");
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

        $totaalprijs = $totaalprijs + ($infoproduct["SellPrice"]* $aantalproduct);
        $totaalprijsproduct = ($infoproduct["SellPrice"]* $aantalproduct);

        /*print("
                    
                        <img src='https://media.tarkett-image.com/large/TH_25121916_25131916_25126916_25136916_001.jpg' width='100%' height='1px'>
                            <img align ='left' class='media-object' src= '$img' style='width: 10%;'>
                            
                                <h3 align='right' class='media-heading' style='color: blue;'>" . $infoproduct["StockItemName"] . "</h3>
                                
                                <h4 align='right' style='color: green;'>Prijs $aantal * " . $infoproduct["SellPrice"] . " = (" . $totaalprijsproduct . ")</h4>
                            
                        
                    ");*/



    ?>


        <img align ='left' class='media-object' src= '<?php print $img; ?>' style='width: 8%;'>

        <h3 align='right' class='media-heading' style='color: blue;'><?php print $infoproduct["StockItemName"]; ?></h3>

        <h4 align='right' style='color: green;'><?php print ("Prijs " . number_format((float)$infoproduct["SellPrice"], 2, '.', '')  . " * " . $aantalproduct . " = " . number_format((float)$totaalprijsproduct, 2, '.', '') . " €");?></h4>
        <img src='https://media.tarkett-image.com/large/TH_25121916_25131916_25126916_25136916_001.jpg' width='100%' height='1px'>








    <?php
}
    ?>
      <h2 align="right"><?php print number_format((float)$totaalprijs, 2, '.', '') ?> €.-</h2>
    </div>
    <?php
}
?>
        <br><br><br><br>
</div>




<!-- SRC= https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_accordion !-->
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
<?php
}
else{
    print('<script type="text/javascript">location.href = "login.php";</script>'); /*SRC="https://stackoverflow.com/questions/4871942/how-to-redirect-to-another-page-using-php"*/
}
include __DIR__ . "/footer.php";

?>