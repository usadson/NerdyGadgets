<?php
include __DIR__ . "/header.php";
include_once "connect.php";
include __DIR__ . "/functions.php";
global $Connection;
?>
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






<div align="center" width="80%" style="background-color: white"><h1>Uw bestellingen</h1>
<?php





/* NIEUWE CODE */
$sqlmyorders = mysqli_query($Connection, "SELECT C_OrderID FROM customer_orders WHERE PersonID = " . $_SESSION['UserID'] . " ");
foreach($sqlmyorders AS $orderIDarray){
#print_r($orderID);
$orderID = $orderIDarray['C_OrderID'];

    $sqlItems = mysqli_query($Connection, "SELECT products FROM customer_orders WHERE C_OrderID = '" . $orderID . "' LIMIT 1");

    while($row = mysqli_fetch_assoc($sqlItems)) {

        $producten = unserialize($row['products']);
    }
    print_r($producten);

    $totaalprijs = 0;

/* CART code*/
    foreach($producten as $productid => $aantal){
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

        /*print("
                    
                        <img src='https://media.tarkett-image.com/large/TH_25121916_25131916_25126916_25136916_001.jpg' width='100%' height='1px'>
                            <img align ='left' class='media-object' src= '$img' style='width: 10%;'>
                            
                                <h3 align='right' class='media-heading' style='color: blue;'>" . $infoproduct["StockItemName"] . "</h3>
                                
                                <h4 align='right' style='color: green;'>Prijs $aantal * " . $infoproduct["SellPrice"] . " = (" . $totaalprijsproduct . ")</h4>
                            
                        
                    ");*/

    }

    ?>

    <button class="accordion">Ordernummer: <?php print($orderID); ?></button>
    <div class="panel">
        <img src='https://media.tarkett-image.com/large/TH_25121916_25131916_25126916_25136916_001.jpg' width='100%' height='1px'>
        <img align ='left' class='media-object' src= '$img' style='width: 10%;'>

        <h3 align='right' class='media-heading' style='color: blue;'><?php print $infoproduct["StockItemName"]; ?></h3>

        <h4 align='right' style='color: green;'><?php print ("Prijs " . $infoproduct["SellPrice"]  . " * " . $aantal . " = (" . $totaalprijsproduct . ")");?></h4>





    </div>


    <?php
}
?>
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

include __DIR__ . "/footer.php";
?>