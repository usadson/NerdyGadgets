
<?php
include __DIR__ . "/header.php";
include __DIR__ . "/functions.php";


/* voor oplevering */
error_reporting(0);

?>


<style>
    td {
        color: Black
    }
    
    tr {
        color: Black
    }
    th {
        color: Black
    }
    form {
    width: 200px;
    }

    

</style>


    <div class='col-lg-8'>
        <div class='padding-top-2x mt-2 hidden-lg-up'></div>
        <!-- Wishlist Table-->
        <div class='table-responsive wishlist-table margin-bottom-none'>
            <table class='table'>
                <thead>
                <tr>
                    <th>Product Name</th>
                </tr>
                </thead>
                <tbody>
                <?php

                #verwijderknop
                if (isset($_POST["Removewishlist"])){
                    $RemovewishID = $_POST["Removewishlist"];
                    
                    unset($_SESSION["wishlist"][ $RemovewishID ]);  
                }

                

                foreach($_SESSION["wishlist"] as $productid => $aantal){

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
                                            
                                        } else {
                                        
                                            $img = "Public/StockGroupIMG/" . $infoproduct['BackupImagePath'];
                                            
                                         }
                print ("
                        <tr>
                            <td>
                                <div class='product-item'>
                                    <a class='product-thumb' href='#'><img src='$img' alt='Product' height='200';></a>
                                    <div class='product-info'>
                                        <h4 class='product-title'><a href='#'>" . $infoproduct["StockItemName"] . "</a></h4>
                                        <div class='text-lg text-medium text-muted'>€" . round($infoproduct["SellPrice"], 2) . "</div>
                                        <div>
                                            <div class='d-inline text-success'> " . $infoproduct["QuantityOnHand"] . " </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class='text-center'><a class='remove-from-cart' href='#' data-toggle='tooltip' title='' data-original-title='Remove item'><i class='icon-cross'></i></a></td>
                        </tr>
                        <td>
                            <form method='post' action='wishlist.php' >
                                <input type='Hidden' name='Removewishlist' value='$productid'>
                                <input type='submit' value='verwijder uit wishlist' style='background-color: red;color: white;' >
                            </form>
                        </tbody>
                    </table>
                </div>
            ");

}




include __DIR__ . "/footer.php";
?>


