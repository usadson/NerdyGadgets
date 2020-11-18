<?php
include_once __DIR__ . "/../connect.php";

/**
 * ItemInformation.
 *
 * Deze class houdt informatie over een stockitem. Dit zorgt ervoor dat de
 * functie ItemInfo() alle benodigde informatie kan terugsturen naar degene
 * die de functie heeft aangeroepen.
 */
class ItemInformation {

  public $Name;
  public $Price;
  public $Image;

  public function __construct(string $name, float $price, string $image) {
    $this->Name = $name;
    $this->Price = $price;
    $this->Image = $image;
  }
}

/**
 * GetPrimaryImage.
 *
 * Het plaatje die gepakt wordt uit de stockitems.ImagePath.
 *
 * @param mysqli $connection De connectie die gebruikt wordt om met de
 *                           nerdygadgets database te communiceren
 * @param int $productID De identificatie nummer van een product dat overeenkomt
 *                       met `stockitems.StockItemID`
 *
 * @return string|null het pad relatieve pad naar het plaatje van de item
 *                     vanaf de nerdygadgets/Public/ map.
 */
function GetPrimaryImage(mysqli $connection, int $productID) {
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

/**
 * GetSecondaryImage.
 *
 * Het plaatje die gepakt wordt uit de stockgroups.ImagePath als het andere
 * plaatje niet gevonden kon worden.
 *
 * @param mysqli $connection De connectie die gebruikt wordt om met de
 *                           nerdygadgets database te communiceren
 * @param int $productID De identificatie nummer van een product dat overeenkomt
 *                       met `stockitems.StockItemID`
 *
 * @return string|null het pad relatieve pad naar het plaatje van de item
 *                     vanaf de nerdygadgets/Public/ map.
 */
function GetSecondaryImage(mysqli $connection, int $productID) {
  $query = "SELECT ImagePath
            FROM stockgroups
            JOIN stockitemstockgroups ON StockItemID = " . $productID . "
            LIMIT 1";

  $statement = mysqli_prepare($connection, $query);
  mysqli_stmt_execute($statement);
  $headerItem = mysqli_stmt_get_result($statement);

  if ($headerItem->num_rows != 0) {
    return "StockGroupIMG/" . mysqli_fetch_assoc($headerItem)['ImagePath'];
  }

  return null;
}

/**
 * GetItemImage.
 *
 * Het plaatje van een item ophalen uit de database is ingewikkelder dan een
 * simpele SELECT. De tabel stockitems heeft een column met ImagePath, maar die
 * mag NULL zijn. In dat geval moeten we de ImagePath uit stockgroups pakken.
 * Stockgroups zijn groepen waaronder stockitems kunnen vallen, dit mag 0 zijn
 * maar ook meer dan 1, dus we pakken altijd de eerste stockgroup, net als in
 * cart.php
 *
 * @param mysqli $connection De connectie die gebruikt wordt om met de
 *                           nerdygadgets database te communiceren
 * @param int $productID De identificatie nummer van een product dat overeenkomt
 *                       met `stockitems.StockItemID`
 *
 * @return string (non-null) het pad relatieve pad naar het plaatje van de item
 *                vanaf de nerdygadgets/Public/ map.
 */
function GetItemImage(mysqli $connection, int $productID) {
  if (($primary = GetPrimaryImage($connection, $productID)) != null) {
    return $primary;
  }

  if (($secondary = GetSecondaryImage($connection, $productID)) != null) {
    return $secondary;
  }

  die("No image found for productID: " . $productID);
}

/**
 * ItemInfo
 *
 * Haal informatie op van een item met stockitems.StockItemID de $productID is.
 *
 * @param mysqli $connection De connectie die gebruikt wordt om met de
 *                           nerdygadgets database te communiceren
 * @param int $productID De identificatie nummer van een product dat overeenkomt
 *                       met `stockitems.StockItemID`

 *
 * @return ItemInformation De class met informatie over het item
 */
function ItemInfo(mysqli $connection, int $productID) {
	$Query = "SELECT StockItemName, RecommendedRetailPrice
	FROM stockitems S
	WHERE S.StockItemID = " . $productID;

	$Statement = mysqli_prepare($connection, $Query);
	mysqli_stmt_execute($Statement);
  $HeaderItem = mysqli_stmt_get_result($Statement);
  $item = mysqli_fetch_assoc($HeaderItem);

  $Name = $item['StockItemName'];
  $Price = $item['RecommendedRetailPrice'];
  $Image = GetItemImage($connection, $productID);

  return new ItemInformation($Name, $Price, $Image);
}
