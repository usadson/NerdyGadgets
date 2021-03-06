<?php

session_start();
include_once "connect.php";
global $Connection;
if (isset($_SESSION['UserID'])) {
    $LoggedIN = TRUE;
    $LoggedINAS = $_SESSION['UserID'];
    $LogINquery = mysqli_query($Connection, "SELECT FullName FROM people WHERE PersonID = " . $_SESSION['UserID']);
    while($row = mysqli_fetch_assoc($LogINquery)) {
        $FullName = $row['FullName'];
    }
}



else{
    $LoggedIN = FALSE;
}

if(isset($_POST["quantity"])) {
    if ($_POST["quantity"] > 0 && $_POST["quantity"] <= $infoproduct["QuantityOnHand"]) {
        $aantal = $_POST["quantity"];
        $productid = $_POST["productid"];
        $_SESSION["mand"][$productid] = $aantal;
    }
}

if(!isset($_SESSION["mand"])){
    $_SESSION["mand"]=[];
}  

if(!isset($_SESSION["wishlist"])){
    $_SESSION["wishlist"]=[];
}
if($LoggedIN == TRUE){
    $sqlcartcheck = mysqli_query($Connection, "SELECT * FROM people_cart WHERE PersonID = " . $_SESSION['UserID']);
    if (mysqli_num_rows($sqlcartcheck) == 0) {
        $sqladdcart = ("
INSERT INTO people_cart(PersonID, cart)
VALUES (" . $_SESSION['UserID'] . ", 'a:0:{}')"); /* */
        mysqli_query($Connection, $sqladdcart);
    }
    /*Begin versturen*/
    /* Maakt informatie cart klaar voor database*/
    $serieel = serialize($_SESSION['mand']);



    /*SQL insert cart deel*/
    $sqlupdatecart = ("
UPDATE people_cart
 SET cart = '" . $serieel . "' 
 WHERE PersonID = " . $_SESSION['UserID']);
    mysqli_query($Connection, $sqlupdatecart);
    /* Einde versturen */


    /* zet informatie terug naar php array */

    $sqlgetcart = mysqli_query($Connection, "SELECT cart FROM people_cart WHERE PersonID = " . $_SESSION['UserID']);

    $_SESSION['mand'] = [];
    while($row = mysqli_fetch_assoc($sqlgetcart)) {
        $_SESSION['mand'] = unserialize($row['cart']);
    }

    $nonserieel = unserialize($serieel);
}



?>
<!DOCTYPE html>
<html lang="en" style="background-color: rgb(255, 255, 255);"> 
<head>
    <script src="Public/JS/fontawesome.js" crossorigin="anonymous"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/Resizer.js"></script>
    <script src="Public/JS/jquery-3.4.1.js"></script>
    <style>
        @font-face {
            font-family: MmrText;
            src: url(/Public/fonts/mmrtext.ttf);
        }


        .dropbtn {
            background-color: white;
            color: black;
            padding: 6px;
            font-size: 16px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 5px 3px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {background-color: #ddd;}

        .dropdown:hover .dropdown-content {display: block;}

        .dropdown:hover .dropbtn {background-color: #bbb;}
    </style>
    <meta charset="ISO-8859-1">
    <title>NerdyGadgets</title>
    <link rel="stylesheet" href="Public/CSS/Style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/nha3fuq.css">
    <link rel="apple-touch-icon" sizes="57x57" href="Public/Favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="Public/Favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="Public/Favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="Public/Favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="Public/Favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="Public/Favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="Public/Favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="Public/Favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="Public/Favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="Public/Favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Public/Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="Public/Favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Public/Favicon/favicon-16x16.png">
    <link rel="manifest" href="Public/Favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="Public/Favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<div>

        <div class="row" id="Header">
            <div class="col-2"><a href="./" id="LogoA">
                    <div id="LogoImage"></div>
                </a></div>
            <div class="col-8" id="CategoriesBar">
                <ul id="ul-class">
                    <li>
                        <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                    </li>
                <?php
                $Query = "
                SELECT StockGroupID, StockGroupName, ImagePath
                FROM stockgroups
                WHERE StockGroupID IN (
                                        SELECT StockGroupID
                                        FROM stockitemstockgroups
                                        ) AND ImagePath IS NOT NULL
                ORDER BY StockGroupID ASC";
                    $Statement = mysqli_prepare($Connection, $Query);
                    mysqli_stmt_execute($Statement);
                    $HeaderStockGroups = mysqli_stmt_get_result($Statement);

                    foreach ($HeaderStockGroups as $HeaderStockGroup) {
                        ?>
                        <li>
                            <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                               class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                        </li>
                    
                        <?php
                    }
                    ?>
                    <li><a href="browse.php" style="color:#000;padding-left: 50px;" align="center" ><i class="fas fa-search" style="color:#676EFF;"></i> Zoeken</a>




                        <?php
                        /* FILLER moet nog een pagina voor komen*/
                        if($LoggedIN == true){
                            print('<li><img src="Public/Img/Account.png" style="padding-right: 0px;width: 4%;"> <i  style="color:#676EFF;"></i> <div class="dropdown">
  <button class="dropbtn">' . $FullName . '</button>
  <div class="dropdown-content">
    <a href="Orders.php">Bestellingen</a>
    <a href="wishlist.php">Wishlist</a>
    <a style="color: white; background-color: red;" href="Uitloggen.php">Uitloggen</a>
  </div>
</div>');

                        }
                        else{
                            print('<a href="login.php"> <img src="Public/Img/Log in.png" style="padding-left:5px; padding-left:18px;padding-right:5px;width:8%"></a></а>');
                        }
                        ?>
                        <a href="cart.php">
                            <img alt="Winkelwagen" src="Public/Img/cart.png" align="right" style="padding-left:20px; padding-top:28px;padding-right:0px;width:5%">
                        </a>
                    </li>
                    </li>
                </ul>
            </div>
        </div>
    <br><br><br><br><br><br>
        </div>
    </html>
