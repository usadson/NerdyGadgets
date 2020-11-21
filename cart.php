<?php
include ('header.php');
global $Connection;
/* voor oplevering */
error_reporting(0);

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

  span#noProductsWarning {
    display: block;
    font-size: 26px;
    text-align: center;
    width: 100%;
  }

  button.big-button {
    background-color: #22aa19;
    border: none;
    border-radius: 7px;
    color: #eeeeee;
    cursor: pointer;
    display: inline-block;
    font-size: 22px;
    padding: 15px;
    text-align: center;
    width: 300px;

    margin: 50px 5px 5px;
  }

  button.big-button span {
    cursor: pointer;
    display: inline-block;
    position: relative;
  }

  div.title1 {
    margin-top: 50px;
    margin-bottom: 15px;
  }

  div.title2 {
    margin-bottom: 40px;
  }
  
  #shoppingCartTitle {
    color: #05d670;
    font-weight: 600;
  }

</style>

<div style="text-align: center">
<header>
    <div class="title1"><h1 id="shoppingCartTitle">Winkelwagen</h1></div>
    <div id="subTitle" class="title2"> <h2>Hier zijn je producten</h2></div>
</header>
</div>

<div id="tableContainer" class="container mb-4">
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
<<<<<<< HEAD




					if ($_POST['deleteall'] == "Verwijder alles"){
						print('<h5 align="center"><b>Alle producten zijn verwijderd</b></h5>');
						unset($_SESSION["cart"]);
					}
					else{
					}






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





                      	$quantity = 1;
			$qp = $price * $quantity;

                      print("<tr>");

                      print("<td><img src=\"Public/" . $image . "\" alt=\"Product Plaatje\"></td>");
                      print("<td>" . $name . "</td>");
                      print("<td>" . ($isInStock ? "Op voorraad" : "Niet op voorraad") . "</td>");
                      print('<td><input class="form-control" type="text" value="' . $quantity . '" /></td>');
                      print("<td class=\"text-right\">€ " . $qp . '</td>');
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


=======
                    include("Modules/ComputeShoppingCartTable.php");
>>>>>>> 627aefd2d4995f95a5b96fb666cf299ef232c913
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<span id="noProductsWarning" style="opacity:0">
  Je hebt nog geen producten in je winkelmandje<br>
   gedaan, zullen we verder gaan met winkelen?
</span>

<!-- button section -->
<div style="text-align: center">
  <a href="browse.php">
    <button class="big-button" type="button">Verder winkelen</button>
  </a>
  <a href="betaalpagina.php" id="cartToPaymentSectionContainer" >
    <button class="big-button" type="button">Naar betaling</button>
  </a>
  <form id="cartRemoveAllContainer" action="Interface/TruncateCart.php" method="post">
    <input type="submit" value="Verwijder alles">
  </form>
</div>

<?php
/**
 * PREFACE: Het verwijderen van een enkel product van de pagina.
 * --------------------------------------------------------------------------
 * Het verwijderen van een product moet gedaan worden met PHP, want dit is de
 * rol die de session (dus de winkelwagen gegevens) beheert.
 *
 * Nu is het probleem dat PHP wordt uitgevoerd voordat de pagina naar de
 * browser wordt gestuurd. Om dit te 'omzeilen' kunnen we gebruik maken van
 * van <form>s. Dit kunnen we doen op twee manieren:
 *
 * 1. Bij elk product een nieuwe <form> te gebruiken en daar een
 * <input type="hidden" value="..."> te plaatsen met als waarde het product ID.
 * Dit is een heel lelijke manier om het te doen, en dit valt ook onder
 * DOM-bloating.
 *
 * 2. Bij elk product een custom attribuut te gebruiken, met als waarde de
 * product ID. (data-product-id="..."). Dan hebben we onderaan de pagina een
 * JavaScript blok die voor elk element met zo'n attribuut een actie geeft voor
 * als je op de 'Verwijder' knop drukt.
 *
 *
 *
 */
?>
<script>
  /**
   * Pak elk <td> element met een data-product-id attribuut.
   */
  let collection = document.querySelectorAll("td[data-product-id]");

  /**
   * De status als een item wordt verwijdert of niet.
   *
   * Als je een item verwijdert, duurt het even om te laden. Als de gebruiker
   * in de tussentijd nog een product verwijdert, kan het niet helemaal
   * kloppen.
   */
  let isInProgress = false;

  function activateProgress() {
    if (isInProgress) {
        return false;
    }

    isInProgress = true;
    console.log("Progress: activating...");

    for (let i = 0; i < collection.length; i++) {
      let trashButton = collection[i].querySelector("i.fa-trash");
      trashButton.parentElement.style.backgroundColor = "#aaa";
      trashButton.enabled = false;
    }

    console.log("Progress: activated");

    return true;
  }

  function deactivateProgress() {
    console.log("Progress: deactivating... ");
    for (let i = 0; i < collection.length; i++) {
        let trashButton = collection[i].querySelector("i.fa-trash");
        trashButton.parentElement.style.backgroundColor = "";
        trashButton.enabled = true;
    }

    console.log("Progress: deactivated");
    isInProgress = false;
  }

  /**
   * Deze functie zorgt ervoor dat de melding dat-er-geen-producten-in-de
   * winkelwagen-zitten wordt weergegeven als er geen producten zijn, of anders
   * verstopt hij deze weer.
   *
   * Ook verstopt hij de irrelevante knoppen/informatie als er geen producten
   * in de winkelwagen zitten.
   */
  function tryUpdateWarningMessage(productCount) {
    let messageElement = document.getElementById("noProductsWarning");
    let shoppingCartTitle = document.getElementById("shoppingCartTitle");

    /**
     * Lijst met irrelevante elementen als de winkelwagen leeg is.
     */
    let containers = ["tableContainer", "cartToPaymentSectionContainer", "cartRemoveAllContainer", "subTitle"];

    if (productCount.toString() === "0") {
      messageElement.style.opacity = "1";
      containers.forEach(name => document.getElementById(name).style.display = "none");
      shoppingCartTitle.innerText = "Je winkelmandje is leeg.";
    } else {
      messageElement.style.opacity = "0";
      containers.forEach(name => document.getElementById(name).style.display = "");
      shoppingCartTitle.innerText = "Winkelwagen";
    }
  }

  /**
   * Dit is de functie die aangeroepen wordt als er op de 'Verwijder' knop
   * gedrukt wordt.
   */
  function deleteItem(element) {
    if (!activateProgress()) {
        return;
    }

    let productID = element.parentElement.getAttribute("data-product-id");
    fetch("Interface/RemoveItem.php?productID=" + productID)
      .then(result => {
          tryUpdateWarningMessage(result.headers.get("X-NG-Products"));
          return result.text();
      })
      .then(data => {
        /**
         * Interface/RemoveItem.php geeft ons de nieuwe tabel weer terug,
         * en we vervangen de oude hiermee:
         */
        document.querySelector("tbody").innerHTML = data;

        deactivateProgress();
      });
  }

  tryUpdateWarningMessage(<?php global $productCount; echo $productCount; ?>);

</script>

</body>
</html>
<?php
include __DIR__ . "/footer.php";
?>
