<html>
<?php
include ('header.php');
include_once "connect.php";
global $Connection;
/*We hebbenn toesteming gekregen om oude wachtwoorden  over te slaan*/
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
  border: 10px solid white;
}
</style>
</head>
<body>
<h1>Er moeten nog checks komen dus niet zomaar gebruiken</h1>
<p></p>
<div align="center" class="FORM">
<form align="left" method="get" action="new_account.php">
<label for="fname" align="left">Voornaam:</label><br>
  <input type="text" id="Voornaam" name="Voornaam" value="<?php print($_GET['Voornaam']);?>"><br>

    <?php
    if($_GET['Voornaam'] == "") {
        print('<p class="error">U moet een voornaam invullen</p>');
    }
    else{
        print("<br>");
    }
    ?>

<label for="fname" align="left">Achternaam:</label><br>
  <input type="text" id="Achternaam" name="Achternaam" value="<?php print($_GET['Achternaam']);?>""><br>


    <?php
    if($_GET['Achternaam'] == "") {
        print('<p class="error">U moet een achternaam invullen</p>');
    }
    else{
        print("<br>");
    }
    ?>

    <label for="fname" align="left">Telefoonnummer:</label><br>
    <input type="text" id="Telefoon" name="Telefoon" value="<?php print($_GET['Telefoon']);?>""><br>


    <?php
    if($_GET['Telefoon'] == "") {
        print('<p class="error">U moet een telefoonnummer invullen</p>');
    }
    else{
        print("<br>");
    }
    ?>

<label for="fname" align="left">Emailadress:</label><br>


 <input type="email" id="Mail" name="Mail" value="<?php print($_GET['Mail']);?>"><br>
    <?php
    /* Er moet nog een check komen voor email formaat*/
    $sqlmailcheck = mysqli_query($Connection, "SELECT EmailAddress FROM people WHERE EmailAddress = '" . $_GET['Mail'] . "' LIMIT 1");
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
        print('<p class="error">U moet een emailadress invullen</p>');
    }
    ?>
 

<label for="fname" align="left">Wachtwoord</label><br>
 <input type="text" id="Wachtwoord1" name="Wachtwoord1"><br><br>
    <?php
    if($_GET['Wachtwoord1'] == ""){
        print('<p class="error">Je moet een wachtwoord invullen</p>');
        /* Wachtwoord complexiteit check*/
    }
    else{
        print('<br>');
    }
    ?>
 <label for="fname" align="left">Herhaling wachtwoord</label><br>
 <input type="text" id="Wachtwoord2" name="Wachtwoord2"><br><br>
    <?php
    if($_GET['Wachtwoord2'] == ""){
    print('<p class="error">Je moet een herhaling van je wachtwoord invullen</p>');
    /* Wachtwoord complexiteit check*/
    }
    else{
      if($_GET['Wachtwoord1'] == $_GET['Wachtwoord2']){
          print('<br>');
      }
      else{
          print('<p class="error">De wachtwoorden komen niet overeen</p>');
      }
    }
    ?>
    <input type="submit">
 </form>
 <?php






     /*Gedeelte wat he nieuwe ID uitkrekend */
 $sqlID = mysqli_query($Connection, "SELECT MAX(PersonID) AS ID FROM people LIMIT 1");
 while($row = mysqli_fetch_assoc($sqlID)) {
     $NewID = ($row['ID'] + 1);
 }


 /* Informatie voor in databasse*/
 $Voornaam = $_GET['Voornaam'];
 $Achternaam = $_GET['Achternaam'];
$Fullname =  ($Voornaam . " " . $Achternaam);
$SearchName = ($Voornaam . " " . $Fullname);
 $Validfrom = (date("Y-m-d"));
 print($Validfrom);
 $Telefoonnummer = $_GET['Telefoon'];
$Wachtwoord = $_GET['Wachtwoord1'];
$Mail = $_GET['Mail'];



 /* INFORMATIE TESTEN
 print("ID: " . $NewID . "<br>");
 print("Mail: " . $_GET['Mail'] . "<br>");
 print("Voornaam: " . $_GET['Voornaam'] . "<br>");
 print("Achternaam: " . $_GET['Achternaam'] . "<br>");
 print("Wachtwoord: " . $_GET['Wachtwoord1'] . "<br>");
 Print($Validfrom);
*/
/*ER MOETEN NOG CHECKS KOMEN DUS NIET GEBRUIKEN */
 $sqladdaccount = ("INSERT INTO people(PersonID, FullName, PreferredName, SearchName, IsPermittedToLogon, LogonName, HashedPassword, EmailAddress, ValidFrom, ValidTo)
VALUES (" . $NewID . ", '" . $Fullname . "', '" . $Voornaam . "','" . $SearchName. "', 1, '" . $Mail ."', '" . $Wachtwoord . "', '" . $Mail . "', '" . $Validfrom . " 00:00:00', '9999-12-31 23:59:59')

");
 mysqli_query($Connection, $sqladdaccount);
 ?>

</div>
</body>
</html>