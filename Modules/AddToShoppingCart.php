<?php

// Product identifier ophalen uit doorgestuurde informatie (d.w.z. uit de <form> van view.php).
$productID = $_POST["productID"];

session_start();

// Als we een nieuwe session hebben, moeten we een nieuwe 'cart' array
// aanmaken voordat we deze kunnen gebruiken.
if (!isset($_SESSION["cart"])) {
  $_SESSION["cart"] = array();
}

// Product toevoegen aan de shopping cart array
array_push($_SESSION["cart"], $productID);

// Doorverwijst worden naar de visuele shopping cart pagina.
header("Location: ../cart.php");
