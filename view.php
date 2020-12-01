<?php

$Connection = null;
include_once('connect.php');

include "./header.php";

$Query = " 
           SELECT SI.StockItemID, 
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, 
            StockItemName,
            CONCAT('Voorraad: ',QuantityOnHand)AS QuantityOnHand,
            SearchDetails, 
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath   
            FROM stockitems SI 
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

$ShowStockLevel = 1000;
$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
    $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
} else {
    $Result = null;
}

$ProductID = $Result["StockItemID"];

$wishlistQuery = "
                    INSERT INTO wishlist (PersonID, StockItemID)
                    VALUES(" . $_SESSION["UserID"] . ", " . $productID . ")";





//Get Images
$Query = "
                SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = ?";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
mysqli_stmt_execute($Statement);
$R = mysqli_stmt_get_result($Statement);
$R = mysqli_fetch_all($R, MYSQLI_ASSOC);



if ($R) {
    $Images = $R;
}
?>
<div id="CenteredContent">
    <?php
    if ($Result != null) {
        ?>
        <?php
        if (isset($Result['Video'])) {
            ?>
            <div id="VideoFrame">
                <?php print $Result['Video']; ?>
            </div>
        <?php }
        ?>


        <div id="ArticleHeader">
            <?php
            if (isset($Images)) {
                // print Single
                if (count($Images) == 1) {
                    ?>
                    <div id="ImageFrame"
                         style="background-image: url('Public/StockItemIMG/<?php print $Images[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                    <?php
                } else if (count($Images) >= 2) { ?>
                    <div id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($Images); $i++) {
                                    ?>
                                    <li data-target="#ImageCarousel"
                                        data-slide-to="<?php print $i ?>" <?php print (($i == 0) ? 'class="active"' : ''); ?>></li>
                                    <?php
                                } ?>
                            </ul>

                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($Images); $i++) {
                                    ?>
                                    <div class="carousel-item <?php print(($i == 0) ? 'active' : ''); ?>">
                                        <img alt="Afbeelding van het product" src="Public/StockItemIMG/<?php print $Images[$i]['ImagePath'] ?>">
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div id="ImageFrame"
                     style="background-image: url('Public/StockGroupIMG/<?php print $Result['BackupImagePath']; ?>'); background-size: cover;"></div>
                <?php
            }
            ?>


            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $Result['StockItemName']; ?>
            </h2>
            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">
                        <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $Result['SellPrice']); ?></b></p>
                        <h6> Inclusief BTW </h6>
                        <form method="POST" action="Modules/AddToShoppingCart.php">
                          <input name="productID" type="hidden" value="<?php print($_GET['id']);?>">
                          <button type="submit" id="view-add-shopping-cart">In mijn winkelwagen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p><?php print $Result['SearchDetails']; ?></p>
        </div>
        <div id="StockItemSpecifications">
            <h3>Artikel specificaties</h3>
            <?php
            $CustomFields = json_decode($Result['CustomFields'], true);
            if (is_array($CustomFields)) { ?>
                <table>
                <thead>
                  <tr>
                    <th>Naam</th>
                    <th>Data</th>
                  </tr>
                </thead>
                <?php
                foreach ($CustomFields as $SpecName => $SpecText) { ?>
                    <tr>
                        <td>
                            <?php print $SpecName; ?>
                        </td>
                        <td>
                            <?php
                            if (is_array($SpecText)) {
                                foreach ($SpecText as $SubText) {
                                    print $SubText . " ";
                                }
                            } else {
                                print $SpecText;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </table><?php
            } else { ?>

                <p><?php print $Result['CustomFields']; ?>.</p>
                <?php
            }
            ?>
            <?php

            # eerst css gekopieërd van het style.css bestand en een nieuwe naam gegeven
            # vervolgens is de database een nieuwe tabel aangemaakt die stockitems_review heet
            # mockdata in de tabel gegooid om als zogenaamde review te gebruiken
            # het background element van css klopt niet dus met element inspecteren tijdelijk weggehaald om de review te kunnen bekijken
            # query gemaakt om de gegevens van de database te kunnen gebruiken op de website
            # in de WHERE clausule hebbben we een vraagteken neergezet tegen sql-injecties
            # de vraagteken moet nog een waarde krijgen en dat wordt in ------- mysqli_stmt_bind_param($Statement, "i", $_GET['id']); ------ dit stukje code gedaan
            # daarvoor is tristans code hergebruikt en variabele verandert naar de query naam:---------- $Query_reviews---------
            # als $R bij ----- mysqli_fetch_all($R, MYSQLI_ASSOC); ----- een 0 geeft, komt hij niet door de if-statement heen en wordt er geen waarde meegegeven
            # vervolgens in het css stukje een foreach gebruikt om de reviews onder elkaar te printen, als er geen reviews zijn, krijg je de pop-up dat er nog geen reviews zijn.
            print ("<form action='view.php?id=$ProductID' action='$wishlistQuery' method='post'>
        
            <input type='submit' value='Voeg toe aan wishlist' name='knoptoevoegenwish'>
        
            </form>");  
        

            if (isset($melding)){
                print($melding);
            }


            $Query_reviews = "
                        SELECT *
                        FROM stockitems_review
                        WHERE StockItemID = ?";


            $Statement = mysqli_prepare($Connection, $Query_reviews);
            mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
            mysqli_stmt_execute($Statement);
            $R = mysqli_stmt_get_result($Statement);
            $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

            if ($R) {
                $Review = $R;
            }
            ?>
        </div>
        <div id="StockItemReviews">
            <h3>Artikel reviews</h3>
            <p><?php
                if (!isset($Review)){
                    print ("er zijn nog geen reviews");
                }else{
                    foreach($Review as $value) {
                        print $value['Review'] . "</br>";
                    }
                }
                ?>
            </p>
        </div>
        <?php
    } else {
        ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
    } ?>
</div>
<?php
include __DIR__ . "/footer.php";
?>