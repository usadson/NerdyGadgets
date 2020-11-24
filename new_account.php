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
 <input type="text" id="Wachtwoord1" name="Wachtwoord1"><br><br>
 
 <label for="fname" align="left">Herhaling wachtwoord</label><br>
 <input type="text" id="Wachtwoord2" name="Wachtwoord2"><br><br>
    <input type="submit">
 </form>
 <?php



 /* hieronder is een check op de wachtwoorden -- Vincent */
 if($_GET['Voornaam'] == "" && $_GET['Achternaam'] == ""){
     print("Je moet de naam velden nog invullen <br>");

     }
 /* SRC= https://www.w3schools.com/php/php_form_url_email.asp */
     if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_GET['Mail'])) {
         print("Mailadress klopt niet <br>");
     }

     if ($_GET['Wachtwoord2'] == "" && $_GET['Wachtwoord1'] == "") {
         print("Je moet beide wachtwoord velden invoeren <br>");
     } else {
         if (($_GET['Wachtwoord1']) == $_GET['Wachtwoord2']) {
             print("mooi man");
         } else {
             print("De wachtwoorden komen niet overheen");
         }
     }

 ?>
</div>
</body>
</html>