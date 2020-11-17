<?php
/**
 * Dit script is een interface. JavaScript roept dit script aan.
 *
 * Dit script voegt het aangevraagde product toe aan de winkelwagen en geeft alle shopping cart items terug.
 */

/**
 * Probeer de kwantiteit te verhogen van producten als hij al erin is.
 * We willen niet 2x hetzelfde product te hebben, we willen dat er 1 product is met een kwantiteit van 2.
 */
function MergeShoppingCartEntries($products, $product) {
  foreach ($products as $productEntry) {
    if ($productEntry["productID"] == $product) {
      $productEntry["quantity"] += 1;
      return true;
    }
  }

  return false;
}

if (!isset($_POST["product"]) || empty($_POST["product"])) {
  echo "Ongeldige aanvraag, informatie niet gegeven.";
  exit(1);
}

// 'start' de sessie:
// Haal de oude sessie op of maak een nieuwe aan als er nog geen is.
session_start();

include("../Modules/Storage.php");

// Haal de producten op uit de shopping cart.
$products = ShoppingCart\GetProducts();
if ($products == null) {
  $products = array();
}

if (!MergeShoppingCartEntries($products, $_POST["product"])) {
  array_push($products, new \ShoppingCart\Entry($_POST["product"], 1));
}

$_PRODUCT["product"] = $products;

echo json_decode($products);

