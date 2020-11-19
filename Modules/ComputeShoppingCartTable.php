<?php

global $Connection;

function PrintProductRow($productID, $image, $name, $isInStock, $quantity, $price) {
  $quantity = 1;
  $qp = $price * $quantity;

  print("<tr>");

  print("<td><img src=\"Public/" . $image . "\" alt=\"Product Plaatje\"></td>");
  print("<td>" . $name . "</td>");
  print("<td>" . ($isInStock ? "Op voorraad" : "Niet op voorraad") . "</td>");
  print('<td><input class="form-control" type="text" value="' . $quantity . '" /></td>');
  print("<td class=\"text-right\">€ " . $qp . '</td>');

  print('<td class="text-right" data-product-id="' . $productID . '">' .
          '<button onclick="deleteItem(this)" class="btn btn-sm btn-danger">' .
             '<i class="fa fa-trash"></i>' .
           '</button>' .
        '</td>');

  print("</tr>");
}


function MapProductIdWithQuantity($products) {
  $map = array();

  foreach ($products as $product) {
    if (!array_key_exists($product, $map)) {
      $map[$product] = 1;
    } else {
      $map[$product]++;
    }
  }

  return $map;
}


include_once('ItemInfo.php');

/**
 * De teller die bijhoudt hoeveel producten er zijn.
 */
$productCount = 0;

$isCartEmpty = !isset($_SESSION["cart"]) || empty($_SESSION["cart"]);

if (!$isCartEmpty) {
  $map = MapProductIdWithQuantity($_SESSION["cart"]);

  foreach ($map as $productID => $quantity) {
    $itemInformation = ItemInfo($Connection, $productID);
    $productCount++;

    PrintProductRow($productID, $itemInformation->Image, $itemInformation->Name, true, $quantity, $itemInformation->Price);
  }
}

header("X-NG-Products: " . $productCount);

?>

<tr>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td>Sub-Total</td>
  <td class="text-right">000 €</td>
</tr>
<tr>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td>BTW</td>
  <td class="text-right">000 €</td>
</tr>
<tr>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td><strong>Total</strong></td>
  <td class="text-right"><strong>000 €</strong></td>
</tr>
