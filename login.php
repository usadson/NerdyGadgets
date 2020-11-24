<html>
<?php
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
<label for="fname" align="left">Emailadress:</label><br>
  <input type="text" id="ID" name="ID"><br>
<label for="fname" align="left">Wachtwoord:</label><br>
  <input type="text" id="ID" name="Wachtwoord"><br>  
 <input type="submit">
</form> 
<?php
	include_once "connect.php";
	global $Connection;



$WachtwoordInput = $_GET['Wachtwoord'];
$UsernameInput = $_GET['ID'];
/* print ($UsernameInput . $WachtwoordInput . "<br>"); */

if(isset($_GET['ID'])){
    /* Hier moet later GEHASHED WORDEN */
    $Wachtwoord = $WachtwoordInput;

	$query = mysqli_query($Connection, "SELECT PersonID, LogonName, HashedPassword FROM people WHERE LogonName = '" . $UsernameInput . "' AND HashedPassword = '" . $Wachtwoord ."' LIMIT 1");
	/* */
	 
	
	$rows = mysqli_num_rows($query);
	 if($rows == 1){

         while($row = mysqli_fetch_assoc($query)) {
             echo "ID: " . $row["PersonID"] ." - Naam: " . $row["LogonName"]. " - Wachtwoord: " . $row["HashedPassword"] . "<br>";
         }
	 print("<h1>Hij werkt dus gewoon</h1>");
	 }
	 else
	 {
	 print("<h1> hij doet het niet </h1>");
	 }
}
?>
</div>
</body>
</html>