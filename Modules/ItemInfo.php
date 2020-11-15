<?php
 /*
 Er moet een $productID opgegeven worden Die in de session staat dit moet per product uitgevoerd worden (een Loop).
 Je kan de comment hieronder weg halen en de print aan het einde weg halen om dit te testen*/
 
 /*
 $productID = 1;
 */
include_once "../connect.php";
$Query = "SELECT StockItemID, StockItemName, RecommendedRetailPrice FROM stockitems WHERE StockItemID = '" . $productID . "'";
$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_execute($Statement);
$HeaderItems = mysqli_stmt_get_result($Statement);

foreach ($HeaderItems as $HeaderItem) {
    $ID = $HeaderItem['StockItemID'];
    $Name = $HeaderItem['StockItemName'];
    $Price = $HeaderItem['RecommendedRetailPrice'];
    /*print($ID . "|" . $Name . "|" . $Price . "<br>"); -- TEST print*/
}
?>