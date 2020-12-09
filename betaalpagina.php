/*om header.php mee te nemen (layout van de pagina)*/
<?php
include __DIR__ . "/header.php";
include_once "connect.php";
global $Connection;

if($LoggedIN == TRUE) {
    $sqlUserInfo = mysqli_query($Connection, "SELECT * FROM people WHERE PersonID = " . $_SESSION['UserID'] . " LIMIT 1");
    while ($row = mysqli_fetch_assoc($sqlUserInfo)) {
        $FullName = $row['FullName'];
        $FirstName = $row['PreferredName'];
        $Mail = $row['EmailAddress'];
    }
    $LastName = str_replace("" . $FirstName . "", "", "" . $FullName . "");

    print $LastName;
    print $Mail;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <style>

        .container{
            background-color: deepskyblue;
            box-shadow: 1px 1px 2px 1px #00557c;
            padding: 50px 8px 20px 38px;
            width: 25%;
            height: 70%;
            margin-left: 40%;
        }


    </style>

    <div align="center">
    <!--Main layout-->
    <main class="mt-5 pt-4">
        <div class="container">

        <!-- Heading -->
        <h2 class="my-5 h2 text-center">Checkout</h2>


        <!--Grid column-->
        <div class="col-md-8 mb-4">



            <!--Card content-->
            <form class="align-content-center card-body" method="get" action="Orderbevestiging.php">

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-6 mb-2">

                        <!--firstName-->
                        <div class="md-form ">
                            <label for="firstName" class="">Voornaam:</label>
                            <input type="text" id="firstName" value="<?php if($LoggedIN == TRUE) {print $FirstName;} else{print "";} ?>" class="form-control" required>

                        </div>

                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-md-6 mb-2">

                        <!--lastName-->
                        <div class="md-form">
                            <label for="lastName" class="">Achternaam:</label>
                            <input type="text" id="lastName" value="<?php if($LoggedIN == TRUE) {print $LastName;} else{print "";} ?>" class="form-control" required>

                        </div>

                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->


                <!--email-->
                <div class="md-form mb-5">
                    <label for="email" class="">Email:</label>
                    <input type="text" id="email" value="<?php if($LoggedIN == TRUE) {print $Mail;}?>" class="form-control" placeholder="youremail@example.com" required>

                </div>


                <!--address-->
                <div class="md-form mb-5">
                    <label for="address" class="">Adres:</label>
                    <input type="text" id="address" class="form-control" placeholder="" required>

                </div>

                <!--address-2-->
                <div class="md-form mb-5">
                    <label for="address-2" class="">Postcode:</label>
                    <input type="text" id="address-2" class="form-control" placeholder="" required>

                </div>

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-lg-4 col-md-12 mb-4">

                        <label for="country">Land:</label>
                        <select class="custom-select d-block w-100" id="country" required>
                            <option value="">...Kies...</option>
                            <option>Nederland</option>

                        </select>


                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">

                        <label for="state">Provincie:</label>
                        <select class="custom-select d-block w-100" id="state" required>
                            <option value="">...Kies...</option>
                            <option>Noord-Holland</option>
                            <option>Zuid-Holland</option>
                            <option>Zeeland</option>
                            <option>Noord-Brabant</option>
                            <option>Utrecht</option>
                            <option>Flevoland</option>
                            <option>Friesland</option>
                            <option>Groningen</option>
                            <option>Drenthe</option>
                            <option>Overijssel</option>
                            <option>Gelderland</option>
                            <option>Limburg</option>
                        </select>


                    </div>


                    <hr>


                    <div class="col-lg-4 col-md-6 mb-4">

                        <label for="state">Betaalmethode:</label>
                        <select class="custom-select d-block w-100" id="state" required>
                            <option value="">...Kies...</option>
                            <option>iDeal</option>
                            <option>Credit card</option>
                            <option>Paypal</option>

                        </select>


                        <br><br>
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Verder</button>

            </form>


            <div class="col-md-4 mb-4">





            </div>
            </div>


    </main>

    </div>

    <?php
    include __DIR__ . "/footer.php";
    ?>





