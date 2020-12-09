<?php

include __DIR__ . "/header.php";
global $Connection;
?>

    <script src="https://use.fontawesome.com/a6f0361695.js"></script>

    <div align="center" class="ExactCenter">
    <h2 id="fh2">schrijf hier een review over het product</h2>
    <h6 id="fh6">uw review gaat ons helpen met het aanbieden van onze producten.</h6>


    <form id="feedback" action="review.php" method="post">
        <div class="pinfo">naam en achternaam</div>

        <div class="form-group">
            <div class="col-md-8 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input  name="name" placeholder="Jan van Dijk" class="form-control"  type="text">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input name="email" type="email" class="form-control" placeholder="janvandijk@gmail.com">
                </div>
            </div>
        </div>

        <div class="pinfo">hoeveel sterren voor het product</div>


        <div class="form-group">
            <div class="col-md-8 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-heart"></i></span>
                    <select class="form-control" id="rate">
                        <option value="1star">1</option>
                        <option value="2stars">2</option>
                        <option value="3stars">3</option>
                        <option value="4stars">4</option>
                        <option value="5stars">5</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="pinfo">schrijf feedback</div>


        <div class="form-group">
            <div class="col-md-8 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                    <textarea class="form-control" name="comment" id="review" rows="3"></textarea>

                </div>
            </div>
        </div>
        <input type="hidden" name="StockItemID" value="<?php echo $_POST['StockItemID']?>">
        <button name="<?php echo $_POST['StockItemID']; ?>" type="submit" class="btn btn-primary" >plaats review</button>


    </form>
    </div>

<?php
if(isset($_POST['StockItemID']) && isset($_POST['comment'])) {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'NerdyGadgets';

    $link = mysqli_connect("$DATABASE_HOST", "$DATABASE_USER", "", "$DATABASE_NAME");

    /*$Review = $_POST['review'];
    $ID = $_POST['ID'];
    */

    $Query_review2 = "INSERT INTO stockitems_review (StockItemID, Review) VALUES (?, ?)";

    $Statement2 = mysqli_prepare($Connection, $Query_review2);
    mysqli_stmt_bind_param($Statement2, "is", $_POST['StockItemID'], $_POST['comment']);
    mysqli_stmt_execute($Statement2);
}


include __DIR__ . "/footer.php";
?>