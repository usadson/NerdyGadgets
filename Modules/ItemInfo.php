<?php
 /*
 Er moet een $productID opgegeven worden Die in de session staat dit moet per product uitgevoerd worden (een Loop).
 Je kan de comment hieronder weg halen en de print aan het einde weg halen om dit te testen*/
 
 /*
 $productID = 1;
 */
include_once __DIR__ . "/../connect.php";

class ItemInformation {

  public $Name;
  public $Price;
  public $Image;

  public function __construct($name, $price, $image) {
    $this->Name = $name;
    $this->Price = $price;
    $this->Image = $image;
  }
}

function ItemInfo($Connection, $productID) {
	$Query = "SELECT S.StockItemID, StockItemName, RecommendedRetailPrice, ImagePath
	FROM stockitems S
	JOIN stockitemimages I ON I.StockItemID = S.StockItemID
	WHERE S.StockItemID = '" . $productID . "'
	";
	$Statement = mysqli_prepare($Connection, $Query);
	mysqli_stmt_execute($Statement);
  $HeaderItem = mysqli_stmt_get_result($Statement);
  $item = mysqli_fetch_assoc($HeaderItem);

  $Name = $item['StockItemName'];
  $Price = $item['RecommendedRetailPrice'];
  $Image = $item['ImagePath'];

  return new ItemInformation($Name, $Price, $Image);
}

?>