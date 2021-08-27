<?php

$requestedUrl = $_SERVER['REQUEST_URI'];
$baseUrl = removeQueryStringAndParams($_SERVER['REQUEST_URI']);
$parsedUrl = parseUrl($_SERVER['REQUEST_URI']);

$urlMappings = [
	"" => "home.php",
	"/product" => "product.php",
	"/products" => "products.php",
	"/categories" => "categories.php",
	"/cart" => "cart.php",
	"/login" => "login.php",
	"/register" => "register.php",
	"/contact" => "contact.php",
	"/checkout" => "checkout.php",
	"/product/new" => "create-product.php",
	"/product/create" => "api.php",
	"/requestHandler" => "requestHandler.php"
];

# Allow static assets
if ($baseUrl == "/assets") {
	$mime_types = [
		"js" => "text/javascript",
		"css" => "text/css"
	];

	$file = removeQueryString(substr($requestedUrl, 1));
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	$type = $mime_types[$ext] ?? mime_content_type($file);
	header("Content-type: $type");
	echo file_get_contents($file);
	die();
}

$page = $urlMappings[$parsedUrl] ?? "404.php";
$authorized = true;
include("./pages/$page");


function parseUrl($url) {
	return rtrim(removeQueryString($url), "/");
}

function removeQueryStringAndParams($url)
{
	$url = removeQueryString($url);
	$url = removeUrlParams($url);
	$url = "/$url";
	return $url;
}

function removeQueryString($url)
{
	return explode("?", $url)[0];
}

function removeUrlParams($url)
{
	return explode("/", $url)[1];
}
