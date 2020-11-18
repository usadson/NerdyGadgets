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

function GetPrimaryImage($connection, $productID) {
  $query = "SELECT ImagePath
  FROM stockitemimages
	WHERE StockItemID = " . $productID;

  $statement = mysqli_prepare($connection, $query);
  mysqli_stmt_execute($statement);
  $headerItem = mysqli_stmt_get_result($statement);

  if ($headerItem->num_rows != 0) {
    return "StockItemIMG/" .  mysqli_fetch_assoc($headerItem)['ImagePath'];
  }

  return null;
}

function GetItemImage($Connection, $productID) {
  $primary = GetPrimaryImage($Connection, $productID);
  if ($primary != null) {
    return $primary;
  }

  $query = "SELECT ImagePath
            FROM stockgroups
            JOIN stockitemstockgroups ON StockItemID = " . $productID . "
            LIMIT 1";

  $Statement2 = mysqli_prepare($Connection, $query);
  mysqli_stmt_execute($Statement2);
  $HeaderItem2 = mysqli_stmt_get_result($Statement2);

  if ($HeaderItem2->num_rows != 0) {
    return "StockGroupIMG/" . mysqli_fetch_assoc($HeaderItem2)['ImagePath'];
  }

  die("No image found for productID: " . $productID);
}

function ItemInfo($Connection, $productID) {
	$Query = "SELECT StockItemName, RecommendedRetailPrice
	FROM stockitems S
	WHERE S.StockItemID = " . $productID;

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