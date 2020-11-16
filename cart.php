	<?php
include __DIR__ . "/header.php";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nerdygadgets";

$conn = new mysqli($servername, $username, $password, $dbname); /* SRC= https://www.w3schools.com/php/php_mysql_select.asp*/

?>






<html>
<body>
<style>
td {
    color: aliceblue
}
i{
    width: 10px
}
    div.fixed {
        position: fixed;
        bottom: 0;
        padding-left: 0;
        width: 200px;

    }
        </style>



<!-- Title Section -->
<div align="center">
<header>
    <div class="title1"><h1>Winkelwagen</h1></div>
    <div class="title2"> <h2>Hieronder uw producten</h2></div>
</header>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">


    <div class="collapse navbar-collapse justify-content-end" id="navbarsExampleDefault">
        <ul class="navbar-nav m-auto">
            <li class="nav-item m-auto">
                <a class="nav-link" href="index.html">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="category.html">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="product.html">Product</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="contact.html">Cart <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact</a>
            </li>
        </ul>

        <form class="form-inline my-2 my-lg-0">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Search...">
                <div class="input-group-append">
                    <button type="button" class="btn btn-secondary btn-number">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <a class="btn btn-success btn-sm ml-3" href="cart.html">
                <i class="fa fa-shopping-cart"></i> Cart
                <span class="badge badge-light">3</span>
            </a>
        </form>
    </div>
</div>
</nav>


<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"> </th>
                        <th scope="col">Product</th>
                        <th scope="col">Available</th>
                        <th scope="col" class="text-center">Quantity</th>
                        <th scope="col" class="text-right">Price</th>
                        <th> </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><img src="https://dummyimage.com/50x50/55595c/fff" /> </td>
                        <td>Placeholder</td>
                        <td>In stock</td>
                        <td><input class="form-control" type="text" value="1" /></td>
                        <td class="text-right">000 €</td>
                        <td class="text-right"><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button> </td>
                    </tr>
                    <tr>
                        <td><img src="https://dummyimage.com/50x50/55595c/fff" /> </td>
                        <td>Placeholder</td>
                        <td>In stock</td>
                        <td><input class="form-control" type="text" value="1" /></td>
                        <td class="text-right">000 €</td>
                        <td class="text-right"><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button> </td>
                    </tr>
                    <tr>
                        <td><img src="https://dummyimage.com/50x50/55595c/fff" /> </td>
                        <td>Placeholder</td>
                        <td>In stock</td>
                        <td><input class="form-control" type="text" value="1" /></td>
                        <td class="text-right">000 €</td>
                        <td class="text-right"><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button> </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Sub-Total</td>
                        <td class="text-right">000 €</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Shipping</td>
                        <td class="text-right">000 €</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Total</strong></td>
                        <td class="text-right"><strong>000 €</strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- button section -->
<div class="fixed">
    <a href="browse.php">
        <button  type="button" >Verder met winkelen</button>
    </a>
    <a href="betaalpagina.php">
        <button  type="button">Naar betaling </button>
    </a>


</div>



</body>
</html>
<?php
include __DIR__ . "/footer.php";
?>
