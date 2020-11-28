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
?>
<!DOCTYPE html>
<html lang="en" style="background-color: rgb(35, 35, 47);">
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
<body>
<div class="Background">
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
            </ul>
        </div>

        <div id="ul-class-navigation">
          <a href="browse.php" align="center" ><i class="fas fa-search" style="color:#676EFF;"></i> Zoeken</a>
		   <?php
           /* FILLER moet nog een pagina voor komen*/
		  	if($LoggedIN == true){
				print('<div width="20%" align="center" style="padding-left:5px; padding-top:0px;padding-right:5px;"><a href="FILLER.php"> <img src="Public/Img/Account.png" align="left" style="width:9%;padding-top:65px;padding-right:30px">');
				print("<p align='left'>" . $FullName . "</p></a></a></div>");
			}
			else{
				print('<a href="login.php"> <img src="Public/Img/Log in.png" style="padding-left:5px; padding-top:45px;padding-right:5px;float:right;width:10%"></a></а>');
			}
		  ?>

          <a href="cart.php">
            <img alt="Winkelwagen" src="Public/Img/cart.png" align="left" style="padding-left:20px; padding-top:45px;padding-right:20px;width:20%">
          </a>
        </div>
            <!-- Icoon van de wishlist -->
          <!--<a href="wishlist.php">
            <img alt="Wishlist" src="Public/Img/wishlist.jpg" style="padding-left:10px; padding-top:45px;padding-right:20px;float:right;width:70%">
          </a>
          -->




		 
          <!-- Dit is het icoon van de shoppingcart -->
        </div>
    </div>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">


