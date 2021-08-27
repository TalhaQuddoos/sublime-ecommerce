<?php

require_once("__func__.php");

$url = $_SERVER['REQUEST_URI'];
switch($url) {
    case "/product/create":
        $id = $Product->createProduct();
        header("Location: /product?id=$id");
        
}

?>