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

  i#noProductsWarning {
    display: block;
    text-align: center;
    width: 100%;
  }
  
</style>

<div style="text-align: center">
<header>
    <div class="title1"><h1>Winkelwagen</h1></div>
    <div id="subTitle" class="title2"> <h2>Hieronder uw producten</h2></div>
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
                    include("Modules/ComputeShoppingCartTable.php");
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<i id="noProductsWarning" style="opacity:0">Je hebt nog geen producten toegevoegd aan je winkelwagen.</i>

<!-- button section -->
<div style="text-align: center">
  <a href="browse.php">
    <button type="button">Verder met winkelen</button>
  </a>
  <a href="betaalpagina.php" id="cartToPaymentSectionContainer" >
    <button type="button">Naar betaling</button>
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

    /**
     * Lijst met irrelevante elementen als de winkelwagen leeg is.
     */
    let containers = ["tableContainer", "cartToPaymentSectionContainer", "cartRemoveAllContainer", "subTitle"];

    if (productCount.toString() === "0") {
      messageElement.style.opacity = "1";
      containers.forEach(name => document.getElementById(name).style.display = "none");
    } else {
      messageElement.style.opacity = "0";
      containers.forEach(name => document.getElementById(name).style.display = "");
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
