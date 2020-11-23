<?php

/**
 * Haal de sessie op, zodat we de $_SESSION["cart"] kunnen gebruiken.
 */
session_start();

/**
 * We zetten de lijst met winkelwagen producten naar een lege lijst, wat
 * effectievelijk de winkelwagen leegt.
 */
$_SESSION["cart"] = array();

/**
 * We zitten nu op een andere pagina, maar we willen de gebruiker de
 * winkelwagen weer laten zien, dus sturen we ze door naar de juister pagina.
 */
header("Location: ../cart.php");

?>

