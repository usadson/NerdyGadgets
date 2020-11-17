<?php

namespace ShoppingCart {

  class Entry {
    public $productID;
    public $quantity;

    public function __construct($productID, $quantity) {
      $this->$productID = $productID;
      $this->$quantity = $quantity;
    }
  }

  function GetProducts() {
    session_start();
    return $_SESSION['ShoppingCart'];
  }

}

?>