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




$WachtwoordInput = $_GET['Wachtwoord'];
$UsernameInput = $_GET['ID'];
print ($UsernameInput . $WachtwoordInput . "<br>");

if(isset($_GET['ID'])){
	global $Connection;
	$query = mysqli_query($connection, "SELECT HashedPassword, LogonName FROM people WHERE '" . $UsernameInput . "' LIMIT 1");
	/* */
	 
	
	$rows = mysqli_num_rows($query);
	 if($rows == 1){
	 print("Hij werkt dus gewoon");
	 }
	 else
	 {
	 print("<h1>NEEN</h1>");
	 }
}
?>
</div>
</body>
</html>