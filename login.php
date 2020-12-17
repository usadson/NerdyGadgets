<html>
<?php

error_reporting(0);


include ('header.php');
/*We hebbenn toesteming gekregen om oude wachtwoorden  over te slaan*/
?>
<head>
    <style>
        login {
            width: 50%;
            border: 20px solid white;
        }
    </style>
</head>
<body>
<div align="center" class="login">
    <form method="get" action="login.php">
        <label for="fname" align="left" style="color: black;">Emailadress:</label><br>
        <input type="text" id="ID" name="ID"><br>
        <label for="fname" align="left" style="color: black;">Wachtwoord:</label><br>
        <input type="password" id="ID" name="Wachtwoord"><br>
        <input type="submit">
    </form>
    <form method="get" action="new_account.php">
        <button type="submit">Nieuw account aanmaken</button>
    </form>
    <?php
    include_once "connect.php";
    global $Connection;



    $WachtwoordInput = $_GET['Wachtwoord'];
    $UsernameInput = $_GET['ID'];
    /* print ($UsernameInput . $WachtwoordInput . "<br>"); */

    if(isset($_GET['ID'])){
        /* Begin encryptie SRC='https://youtu.be/WwxAyiAtrbM' */
        $key = md5('DonderdagOchtend');
        $salt = md5('DonderdagOchtend');
        $Wachtwoord = $_GET['Wachtwoord'];

        /*$EncryptedWachtwoord = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $Wachtwoord, MCRYPT_MODE_ECB)));*/
        $EncryptedWachtwoord = crypt($Wachtwoord, '$1$' . $salt . '$');
        /* EINDE ECCRYPTIE*/


        $query = mysqli_query($Connection, "SELECT PersonID, LogonName, HashedPassword, FullName FROM people WHERE LogonName = '" . $UsernameInput . "' AND HashedPassword = '" . $EncryptedWachtwoord ."' LIMIT 1");
        /* */


        $rows = mysqli_num_rows($query);
        if($rows == 1){

            while($row = mysqli_fetch_assoc($query)) {
                echo "ID: " . $row["PersonID"] ." - Naam: " . $row["LogonName"]. " - Wachtwoord: " . $row["HashedPassword"] . "<br>";




                $_SESSION['Username'] = $row['FullName'];
                $_SESSION['UserID'] = $row["PersonID"];

            }
            print("<h1>Hij werkt dus gewoon</h1>");

            $sqlgetcart = mysqli_query($Connection, "SELECT cart FROM people_cart WHERE PersonID = " . $_SESSION['UserID']);

            $_SESSION['mand'] = [];
            while($row = mysqli_fetch_assoc($sqlgetcart)) {
                $_SESSION['mand'] = unserialize($row['cart']);
            }
            print('<script type="text/javascript">location.href = "index.php";</script>'); /*SRC="https://stackoverflow.com/questions/4871942/how-to-redirect-to-another-page-using-php"*/

        }
        else
        {
            print("<h3 style='color: red;'> Uw opgegeven wachtwoord en e-mailadress combinatie komt bij ons niet voor.</h3>");
        }
    }
    ?>
</div>
</body>
</html>