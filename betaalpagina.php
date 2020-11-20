//*om header.php mee te nemen (layout van de pagina)
<?php
include __DIR__ . "/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Betalingpagina</title>
    <style>
//*Hoe de select veld eruit ziet*//
        select{

            width: 200px;

        }
//*Verder knop en naam, adres en postcode velden layout*//
        input{
            width: 75px;
        }
        input{
            width: 150px;
        }
//* Box waar de velden in staan*//
.container{
    background-color: dimgrey;
    box-shadow: 1px 1px 2px 1px grey;
    padding: 50px 8px 20px 38px;
    width: 75%;
    height: 75%;
    margin-left: 40%;
}
//*grote van betaalgegevens*//
h1{
    font-size: 30px;
}
    </style>
</head>
<body>
<div class="container">
<h1>Betaalgegevens</h1><br><br>
<form method="GET" action="betaalpagina.php">

        Naam: <input type="text" name="Naam" value=""><br><br>
        Adres: <input type="text" name="Adres" value=""><br><br>
        Postcode: <input type="text" name="Postcode" value=""><br><br>

    <label> Kies uw bank: </label><br>

<select name="Bank">
    <option value=""> --Kies uw bank--</option>
    <option value="ING"> ING </option>
    <option value="ABNAMRO"> ABNAMRO </option>
    <option value="RABOBANK"> RABOBANK </option>
</select><br><br><br>
<form method="GET" action="betaalpagina.php">
    Kortingscode:
    <input type="text" name="code"><br><br><br>

<input type="submit" name="insert" value="Verder"/>

</form>
</div>


</body>
</html>
