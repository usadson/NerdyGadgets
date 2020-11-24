<html>
<?php
include ('header.php');
/*We hebbenn toesteming gekregen om oude wachtwoorden  over te slaan*/
?>
<head>
<style>
FORM {
  width: 50%;
  border: 10px solid white;
}
</style>
</head>
<body>
<p></p>
<div align="center" class="FORM">
<form align="left" method="get" action="new_account.php">
<label for="fname" align="left">Voornaam:</label><br>
  <input type="text" id="Voornaam" name="Voornaam"><br><br>
<label for="fname" align="left">Achternaam:</label><br>
  <input type="text" id="Achternaam" name="Achternaam"><br><br>
<label for="fname" align="left">Emailadress:</label><br>
 <input type="text" id="Mail" name="Mail"><br><br>
 
 
 
<label for="fname" align="left">Wachtwoord</label><br>
 <input type="text" id="Wachtwoord1" name="Wachtwoord1" value="Wachtwoord"><br><br>
 
 <label for="fname" align="left">Herhaling wachtwoord</label><br>
 <input type="text" id="Wachtwoord2" name="Wachtwoord2" value="Herhaal wachtwoord"><br><br>
    <input type="submit">
 </form>
 <?php

 if($_GET['Wachtwoord2'] == "Wachtwoord" && $_GET['Wachtwoord1'] == "Herhaal wachtwoord"){
     print("Je moet beide wachtwoord velden invoeren");
 }
     if ( ($_GET['Wachtwoord1']) == $_GET['Wachtwoord2']){
         print("mooi man");
     }
     else{
         print("De wachtwoorden komen niet overheen");
     }
 
 ?>
</div>
</body>
</html>