<?php include __DIR__ . "/header.php";
global $Connection;

    print($_SESSION['UserID']);
    print ('<br>');
    print_r($_SESSION['mand']);
    print ('<br>');
    /*Kijken of user al een cart heeft */
    $sqlcartcheck = mysqli_query($Connection, "SELECT * FROM people_cart WHERE PersonID = " . $_SESSION['UserID']);
    if (mysqli_num_rows($sqlcartcheck) == 0) {
        print ("ja");
        $sqladdcart = ("
INSERT INTO people_cart(PersonID, cart)
VALUES (" . $_SESSION['UserID'] . ", 'a:0:{}')");
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

$sqlcartcheck = mysqli_query($Connection, "SELECT cart FROM people_cart WHERE PersonID = " . $_SESSION['UserID']);

    $SESSION['mand'] = [];
    


    $nonserieel = unserialize($serieel);


    print($serieel);
    print ('<br>');
    print_r($nonserieel);

?>
