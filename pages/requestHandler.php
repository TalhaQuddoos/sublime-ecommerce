<?php

require_once("__func__.php");

$request = json_decode(file_get_contents("php://input"), true);

$action = $request["action"];

switch($action) {
    case "updateCartQuantity":
        echo $Cart->updateQuantity($request["id"], $request["quantity"]);
        break;
    case "deleteCartItem":
        echo $Cart->deleteItem($request["id"]);
        break;
    case "addToCart":
        echo $Cart->addToCart($request["id"], $request["quantity"]);
        break;
    case "getCartCount":
        echo $Cart->getCartCount();
        break;
    case "getCartTotal":
        echo $Cart->getCartTotal();
        break;
    
}
