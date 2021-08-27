<?php
session_start();

require(__DIR__ . "/../database/DBController.php");
require(__DIR__ . "/../database/Product.php");
require(__DIR__ . "/../database/Auth.php");
require(__DIR__ . "/../database/Cart.php");
$db = new DBController();
$Product = new Product($db);
$Auth = new Auth($db);
$Cart = new Cart($db, $Product);


function formatPrice($price) {
    return number_format((float)$price, 2, '.', '');
}

function capitalize($str) {
    $str[0] = strtoupper($str[0]);
    return $str;
}


