<?php

global $Connection;

function GetUsername() {
  // Magische code om te bepalen of Tristan dit gebruikt of iemand anders
  if (!empty(getenv("APACHE_RUN_DIR"))) {
    return "tager";
  }

  return "root";
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
try {
    $Connection = mysqli_connect("localhost", GetUsername(), "", "nerdygadgets");
    mysqli_set_charset($Connection, 'latin1');
    $DatabaseAvailable = true;
} catch (mysqli_sql_exception $e) {
  var_dump($e);    

	$DatabaseAvailable = false;
}
if (!$DatabaseAvailable) {
    ?><h2>Website wordt op dit moment onderhouden.</h2><?php
    die();
}
