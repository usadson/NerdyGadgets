<?php

namespace ShoppingCart {

  class Entry {
    public $productID;
    public $quantity;
  }

  function GetProducts() {
    session_start();
    return $_SESSION['ShoppingCart'];
  }

}

?>