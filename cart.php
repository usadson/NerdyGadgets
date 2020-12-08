
<?php
include __DIR__ . "/header.php";
include __DIR__ . "/functions.php";

#error_reporting(0);
?>

<style>
td {
    color: black
  }
th {
    color: black
  }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>




<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                #print("dit is de inhoud van POST: ");
                #print_r($_POST);

                
                #verwijderknop
                if (isset($_POST["Remove"])){
                    $RemoveID = $_POST["Remove"];
                    #print("ik ga nu de id verwijderen $RemoveID");
                    unset($_SESSION["mand"][ $RemoveID ]);  
                }
                
                
                $totaalprijs = 0;
                foreach($_SESSION["mand"] as $productid => $aantal){


                    
                    #defining variables
                    /* 
                    $productid = $product["StockItemID"];
                    $productnaam = $product["StockItemName"];
                    $productprijs = round($product["SellPrice"],2);
                    $quantiteit = $product["QuantityOnHand"];
                    $hoeveelheid = $product["aantal"];
                    */
                    #get image

                    #print("product: $productid, aantal: $aantal");
                    $infoproduct = getProductInfo($productid);

                    $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
                    mysqli_set_charset($Connection, 'latin1');

                    $Query = "
                    SELECT ImagePath
                    FROM stockitemimages 
                    WHERE StockItemID = ?";

                    $Statement = mysqli_prepare($Connection, $Query);
                    mysqli_stmt_bind_param($Statement, "i", $productid);
                    mysqli_stmt_execute($Statement);
                    $R = mysqli_stmt_get_result($Statement);
                    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

                    if ($R) {
                        $img = "Public/StockItemIMG/" . $R[0]['ImagePath'];
                        #print($img);
                    } else {
                       
                        $img = "Public/StockGroupIMG/" . $infoproduct['BackupImagePath'];
                        #print ($img);
                    }
                    
                    $totaalprijs = $totaalprijs + ($infoproduct["SellPrice"]* $aantal);
                    
                    
                print("
                    <tr>
                        <td class='col-sm-8 col-md-6'>
                        <div class='media'>
                            <a class='thumbnail pull-left' href='#'> <img class='media-object' src= '$img' style='width: 72px; height: 72px;'> </a>
                            <div class='media-body'>
                                <h4 class='media-heading'><a href='#'>" . $infoproduct["StockItemName"] . "</a></h4>
                                
                                <span> </span><span class='text-success'><strong>" . $infoproduct["QuantityOnHand"] . " Productid: $productid </strong></span>
                            </div>
                        </div></td>
                        <td class='col-sm-1 col-md-1' style='text-align: center'>
                        <form method='post' action='cart.php'>
                                <input type='Hidden' name='productid' value='$productid'>
                                <input type='submit' value='pas aan'>
                                <input type='number' name='quantity' value='$aantal' >
                            </form>
                        </td>
                            <td class='col-sm-1 col-md-1 text-center'><strong>€" . round($infoproduct["SellPrice"], 2) . "</strong></td>
                            <td class='col-sm-1 col-md-1 text-center'><strong>€" . round($infoproduct["SellPrice"], 2) * $aantal ."</strong></td>
                            <td class='col-sm-1 col-md-1'>
                            <form method='post' action='cart.php'>
                                <input type='Hidden' name='Remove' value='$productid'>
                                <input type='submit' value='verwijder' style='background-color: red;color: white;'>
                            </form>
                        </td>
                        
                    </tr>
                    ");
                    #voorwaarde voor de quantiteit knop
                    if(isset($_POST["quantity"])){
                        if($_POST["quantity"] > 0 && $_POST["quantity"] <= $infoproduct["QuantityOnHand"]){
                        $aantal = $_POST["quantity"];
                        $productid = $_POST["productid"];
                        $_SESSION["mand"][$productid] = $aantal;
                        }
                    }
                    
                }
                
                     ?>       
                    
                    
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong>€<?php print(round($totaalprijs,2)); ?></strong></h3></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>
                            <a  href="browse.php">
                                <button type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                                </button>
                             </a>
                        </td>
                        <td>
                            <a  href="betaalpagina.php">
                                <button type="button" class="btn btn-success">
                                 Checkout <span class="glyphicon glyphicon-play"></span>
                                </button></td>
                            </a>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>



































<?php

include __DIR__ . "/footer.php";

?>