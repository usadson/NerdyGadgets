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

function GetItemImage($Connection, $productID) {
  $query = "SELECT ImagePath
	WHERE StockItemID = " . $productID;

  $Statement = mysqli_prepare($Connection, $query);
  mysqli_stmt_execute($Statement);
  $HeaderItem = mysqli_stmt_get_result($Statement);

  if ($HeaderItem->num_rows != 0) {
    return "StockItemIMG" .  mysqli_fetch_assoc($HeaderItem)['ImagePath'];
  } else {
    $query = "SELECT ImagePath
              FROM stockgroups
              JOIN stockitemstockgroups USING(StockGroupID)
              WHERE StockItemID = " . $productID . "
              LIMIT 1";

    $Statement2 = mysqli_prepare($Connection, $query);
    mysqli_stmt_execute($Statement2);
    $HeaderItem2 = mysqli_stmt_get_result($Statement2);

    if ($HeaderItem->num_rows != 0) {
      return mysqli_fetch_assoc($HeaderItem2)['ImagePath'];
    } else {
      die("No image found for productID: " . $productID);
    }
  }
}

function ItemInfo($Connection, $productID) {
	$Query = "SELECT S.StockItemID, StockItemName, RecommendedRetailPrice, ImagePath
	FROM stockitems S
	JOIN stockitemimages I ON I.StockItemID = S.StockItemID";
	$Statement = mysqli_prepare($Connection, $Query);
	mysqli_stmt_execute($Statement);
  $HeaderItem = mysqli_stmt_get_result($Statement);
  $item = mysqli_fetch_assoc($HeaderItem);

  $Name = $item['StockItemName'];
  $Price = $item['RecommendedRetailPrice'];
  $Image = GetItemImage($Connection, $productID);

  return new ItemInformation($Name, $Price, $Image);
}

?>