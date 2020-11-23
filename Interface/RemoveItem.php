<?php

/**
 * Verifieer dat het gegeven productID geldig is.
 *
 * We krijgen deze via een GET variable, ofwel:
 * localhost/nerdygadgets/Interface/RemoveItem.php?productID=...
 */
if (!isset($_GET["productID"]) || empty($_GET["productID"]) || !is_numeric($_GET["productID"])) {
  die("No productID GET variable set");
}

session_start();

/**
 * Haal de lijst met producten op uit de sessie.
 */
$productsInShoppingCart = $_SESSION["cart"];

/**
 * Verwijder alle sloten met het productID dat we willen verwijderen.
 */
$_SESSION["cart"] = array_diff($productsInShoppingCart, array($_GET["productID"]));

include_once("../connect.php");
include("../Modules/ComputeShoppingCartTable.php");

