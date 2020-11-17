<?php
include ('header.php');


?>

<style>
td {
    color: aliceblue
}
i{
    width: 10px
}
th{
    color: aliceblue;
}
img{
    Width: 100px
}
    div.fixed {
        position: fixed;
        bottom: 0;
        padding-left: 0;
        width: 200px;

    }
        </style>

<div align="center">
<header>
    <div class="title1"><h1>Winkelwagen</h1></div>
    <div class="title2"> <h2>Hieronder uw producten</h2></div>
</header>
</div>

<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"> </th>
                        <th scope="col">Product</th>
                        <th scope="col">Available</th>
                        <th scope="col" class="text-center">Quantity</th>
                        <th scope="col" class="text-right">Price</th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    function PrintProductRow($productID, $image, $name, $isInStock, $quantity, $price) {
                      /*
                       * <tr>
                        <td><img src="https://dummyimage.com/50x50/55595c/fff" /> </td>
                        <td>Placeholder</td>
                        <td>In stock</td>
                        <td></td>
                        <td class="text-right">000 €</td>

                    </tr>
                       * */

                      print("<tr>");

                      print("<td><img src=\"Public/StockItemIMG/" . $image . "\" alt=\"Product Plaatje\"></td>");
                      print("<td>" . $name . "</td>");
                      print("<td>" . ($isInStock ? "Op voorraad" : "Niet op voorraad") . "</td>");
                      print('<td><input class="form-control" type="text" value="' . $quantity . '" /></td>');
                      print("<td class=\"text-right\">€ " . $price . '</td>');
                      print('<td class="text-right"><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button></td>');

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

                    include_once('Modules/ItemInfo.php');

                    $isCartEmpty = !isset($_SESSION["cart"]) || empty($_SESSION["cart"]);

                    if (!$isCartEmpty) {
                      $map = MapProductIdWithQuantity($_SESSION["cart"]);

                      foreach ($map as $productID => $quantity) {
                        $itemInformation = ItemInfo($Connection, $productID);

                        PrintProductRow($productID, $itemInformation->Image, $itemInformation->Name, true, $quantity, $itemInformation->Price);
                      }
                    }
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
                        <td>Shipping</td>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php

if ($isCartEmpty) {
  print("<i>Je hebt nog geen producten toegevoegd aan je winkelwagen.</i>");
}

?>

<!-- button section -->
<div class="fixed">
    <a href="browse.php">
        <button  type="button" >Verder met winkelen</button>
    </a>
    <a href="betaalpagina.php">
        <button  type="button">Naar betaling </button>
    </a>


</div>



</body>
</html>
<?php
include __DIR__ . "/footer.php";
?>
