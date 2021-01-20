<html>
<?php
include ('header.php');
include_once "connect.php";
global $Connection;
 error_reporting(0);

 /* Het daadwerkelijk toevoegen staat nu nog uit om dit te testen moet je de comments weghalen aan de onderkant van de pagina waar allemaal #'s staan vergeet ook niet de #'s te verwijderen. */

/* ERROR Reporting moet uit bij oplevering*/
/* Prepare SQLI statements*/
/*We hebbenn toesteming gekregen om oude wachtwoorden  over te slaan*/
/* SQL deel staat gecommend vanwege tests */
$Ingevuld = $_GET['Ingevuld'];



?>
<style>
    p.error {
        color: red;
        font-size: 12px;
    }
</style>
<head>
<style>
FORM {
  width: 50%;
  border: 5px solid black;
    background-color: white;
}
</style>
</head>
<body>
<p></p>
<div align="center" class="FORM">
<form align="left" method="get" action="new_account.php">


    <input type="hidden" id="Ingevuld" name="Ingevuld" value="1">


    <label for="fname" align="left" style="color: black;">Voornaam:</label><br>
  <input type="text" id="Voornaam" name="Voornaam" value="<?php print($_GET['Voornaam']);?> "><br>

    <?php
    if(($_GET['Voornaam'] == "") && isset($Ingevuld)) {
        print('<p class="error">U moet een voornaam invullen</p>');
        $VoldoendeVoornaam = FALSE;
    }
    else{
        print("<br>");
        $VoldoendeVoornaam = TRUE;
    }
    ?>

    <label for="fname" align="left" style="color: black;">Achternaam:</label><br>
  <input type="text" id="Achternaam" name="Achternaam" value="<?php print($_GET['Achternaam']);?>""><br>


    <?php
    if(($_GET['Achternaam'] == "") && isset($Ingevuld)) {
        print('<p class="error">U moet een achternaam invullen</p>');
        $VoldoendeAchternaam = FALSE;
    }
    else{
        print("<br>");
        $VoldoendeAchternaam = TRUE;
    }
    ?>

    <label for="fname" align="left" style="color: black;">Telefoonnummer:</label><br>
    <input type="tel" id="Telefoon" name="Telefoon" value="<?php print($_GET['Telefoon']);?>"><br>


    <?php
    /* CHECK OF TELEFOONNUMMER KAN KLOPPEN TOEVOEGEN*/
    if(($_GET['Telefoon'] == "") && isset($Ingevuld)) {
        print('<p class="error">U moet een telefoonnummer invullen</p>');
        $VoldoendeTEL = FALSE;
    }
    else{
        print("<br>");
        $VoldoendeTEL = TRUE;
    }
    ?>

    <label for="fname" align="left" style="color: black;">Emailadress:</label><br>


 <input type="email" id="Mail" name="Mail" value="<?php print($_GET['Mail']);?>"><br>
    <?php
    $sqlmailcheck = mysqli_query($Connection, "SELECT EmailAddress FROM people WHERE LogonName = '" . $_GET['Mail'] . "' LIMIT 1");
    if($_GET['Mail'] != "") {

        if (mysqli_num_rows($sqlmailcheck) == 0) {
            $Uniekemail = TRUE;
            print("<br>");

        } else {
            print("<p class='error'>Dit emailadress komt al voor bij ons</p>");
            $Uniekemail = FALSE;
        }
    }
    else{
        $Uniekemail = FALSE;
        if(isset($Ingevuld)){
            print('<p class="error">U moet een emailadress invullen</p>');
        }
        else{
            print("<br>");
        }
    }
    ?>


    <label for="fname" align="left" style="color: black;">Wachtwoord</label><br>
 <input type="text" id="Wachtwoord1" name="Wachtwoord1"><br><br>
    <?php
    if(($_GET['Wachtwoord1'] == "") && isset($Ingevuld)){
        print('<p class="error">Je moet een wachtwoord invullen</p>');
        /* Wachtwoord complexiteit check*/

    }
    else{

    $uppercase = preg_match('@[A-Z]@', $_GET['Wachtwoord1']);
    $lowercase = preg_match('@[a-z]@', $_GET['Wachtwoord1']);
    $number    = preg_match('@[0-9]@', $_GET['Wachtwoord1']);
        if(isset($Ingevuld)){
            if (!$uppercase || !$lowercase || !$number || strlen($_GET['Wachtwoord1']) < 8) {
                $sterkWachtwoord = FALSE;
                print('<p class="error"> Het wachtwoord moet minimaal 8 karakters lang zijn een hoofdleter en over een nummer beschikken.</p>');
            } else {
                $sterkWachtwoord = TRUE;
                print('<br>');
            }
        }
        else{
            print('<br>');
            $sterkWachtwoord = FALSE;
        }
    }



    ?>
    <label for="fname" align="left" style="color: black;">Herhaling wachtwoord</label><br>
 <input type="text" id="Wachtwoord2" name="Wachtwoord2"><br><br>
    <?php
    if(($_GET['Wachtwoord2'] == "") && isset($Ingevuld)) {
    print('<p class="error">Je moet een herhaling van je wachtwoord invullen</p>');
    /* Wachtwoord complexiteit check*/
        $VoldoendeWW = FALSE;
    }
    else{

      if($_GET['Wachtwoord1'] == $_GET['Wachtwoord2']){
          print('<br>');
          $VoldoendeWW = TRUE;
      }
      else{
          print('<p class="error">De wachtwoorden komen niet overeen</p>');
          $VoldoendeWW = FALSE;
      }
    }
    ?>
    <input type="submit">
 </form>
 <?php
 /* Begin Wachtwoord encryptie SRC="https://youtu.be/WwxAyiAtrbM"*/

 $salt = md5('DonderdagOchtend');
 $Wachtwoord = $_GET['Wachtwoord1'];

 /*$EncryptedWachtwoord = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $Wachtwoord, MCRYPT_MODE_ECB)));*/
 $EncryptedWachtwoord = crypt($Wachtwoord, '$1$' . $salt . '$');
 /*print($EncryptedWachtwoord);*/

 /* Einde Wachtwoord encryptie */





     /*Gedeelte wat he nieuwe ID uitkrekend */
 $sqlID = mysqli_query($Connection, "SELECT MAX(PersonID) AS ID FROM people LIMIT 1");
 while($row = mysqli_fetch_assoc($sqlID)) {
     $NewID = ($row['ID'] + 1);
 }

/* Toevoegen Query */




 /* Informatie voor in databasse*/
 $Voornaam = $_GET['Voornaam'];
 $Achternaam = $_GET['Achternaam'];
$Fullname =  ($Voornaam . " " . $Achternaam);
$SearchName = ($Voornaam . " " . $Fullname);
 $Validfrom = (date("Y-m-d"));

 $Telefoonnummer = $_GET['Telefoon'];

$Mail = $_GET['Mail'];

/* Allround check voor uitvoeren SQL query en Uitvoeren query*/



 if(($Uniekemail == TRUE) && ($VoldoendeWW = TRUE) && ($VoldoendeAchternaam = TRUE) && ($VoldoendeVoornaam = TRUE) && ($VoldoendeTEL = TRUE) && ($sterkWachtwoord == TRUE)) {

  $sqladdaccount = ("
INSERT INTO people(PersonID, FullName, PreferredName, SearchName, IsPermittedToLogon, LogonName, HashedPassword, EmailAddress, IsEmployee, IsSystemUser, IsExternalLogonProvider, IsSalesperson, ValidFrom, ValidTo, LastEditedBy)
VALUES (" . $NewID . " , '" . $Fullname . "', '" . $Voornaam . "', '" . $SearchName . "', 1, '" . $Mail . "', '" . $EncryptedWachtwoord . "', '" . $Mail . "', 0, 0, 0, 0, 2013-01-01-00-00-00, 9999-12-31-00-00-00, 4000)");
 mysqli_query($Connection, $sqladdaccount);

     print('<script type="text/javascript">location.href = "login.php";</script>'); /*SRC="https://stackoverflow.com/questions/4871942/how-to-redirect-to-another-page-using-php"*/
}

 ?>

</div>
</body>
</html>