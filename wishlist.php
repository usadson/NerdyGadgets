
<?php
include ('header.php');
global $Connection;
/* voor oplevering */
error_reporting(0);

?>


<style>
    td {
        color: aliceblue
    }
    tr {
        color: aliceblue
    }
    th {
        color: aliceblue
    }

</style>


<div class="col-lg-8">
    <div class="padding-top-2x mt-2 hidden-lg-up"></div>
    <!-- Wishlist Table-->
    <div class="table-responsive wishlist-table margin-bottom-none">
        <table class="table">
            <thead>
            <tr>
                <th>Product Name</th>
                <th class="text-center"><a class="btn btn-sm btn-outline-danger" href="#">Clear Wishlist</a></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <div class="product-item">
                        <a class="product-thumb" href="#"><img src="https://via.placeholder.com/220x180/FF0000/000000" alt="Product"></a>
                        <div class="product-info">
                            <h4 class="product-title"><a href="#">PRODUCT</a></h4>
                            <div class="text-lg text-medium text-muted">$00.00</div>
                            <div>Availability:
                                <div class="d-inline text-success">In Stock</div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center"><a class="remove-from-cart" href="#" data-toggle="tooltip" title="" data-original-title="Remove item"><i class="icon-cross"></i></a></td>
            </tr>
            <tr>
                <td>
                    <div class="product-item">
                        <a class="product-thumb" href="#"><img src="https://via.placeholder.com/220x180/87CEFA/000000" alt="Product"></a>
                        <div class="product-info">
                            <h4 class="product-title"><a href="#">PRODUCT</a></h4>
                            <div class="text-lg text-medium text-muted">$00.00</div>
                            <div>Availability:
                                <div class="d-inline text-warning">2 - 3 Weeks</div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center"><a class="remove-from-cart" href="#" data-toggle="tooltip" title="" data-original-title="Remove item"><i class="icon-cross"></i></a></td>
            </tr>
            <tr>
                <td>
                    <div class="product-item">
                        <a class="product-thumb" href="#"><img src="https://via.placeholder.com/220x180/483D8B/000000" alt="Product"></a>
                        <div class="product-info">
                            <h4 class="product-title"><a href="#">PRODUCT</a></h4>
                            <div class="text-lg text-medium text-muted">$00.00</div>
                            <div>Availability:
                                <div class="d-inline text-success">In Stock</div>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="text-center"><a class="remove-from-cart" href="#" data-toggle="tooltip" title="" data-original-title="Remove item"><i class="icon-cross"></i></a></td>
            </tr>
            </tbody>
        </table>
    </div>
    <hr class="mb-4">
    <div class="custom-control custom-checkbox">
        <input class="custom-control-input" type="checkbox" id="inform_me" checked="">
        <label class="custom-control-label" for="inform_me">Inform me when item from my wishlist is available</label>
    </div>
</div>

<?php
include __DIR__ . "/footer.php";
?>


