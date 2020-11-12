<?php
include __DIR__ . "/header.php";
?>
<html>
<body>
<style>

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

<!-- Body section -->
<div class = "body_sec">
    <section id="Content">
        <h5>lijst van artikellen</h5>

    </section>
</div>
</div>
<!-- button section -->
<div class="fixed">
    <a href="browse.php">
        <button  type="button" >Verder met winkelen</button>
    </a>

    <button  type="button">Naar betaling</button>
</div>



</body>
</html>
<?php
include __DIR__ . "/footer.php";
?>
