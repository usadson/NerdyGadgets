<?php
include __DIR__ . "/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Betalingpagina</title>
    <style>

        select{
            position: fixed;

            width: 150px;

        }

        input{
            postion: fixed;
            width: 75px;
        }

.container{
    background-color: dimgrey;
    box-shadow: 1px 1px 2px 1px grey;
    padding: 50px 8px 20px 38px;
    width: 30%;
    height: 50%
    margin-left: 35%;
}
    </style>
</head>
<body>
<div class="container">
<label> Kies uw bank: </label><br>

<select name="Bank">
    <option value=""> --Kies uw bank--</option>
    <option value="ING"> ING </option>
    <option value="ABNAMRO"> ABNAMRO </option>
    <option value="RABOBANK"> RABOBANK </option>
</select><br><br><br>

<input type="submit" name="insert" value="Verder"/>
</form>
</div>
</body>
</html>
