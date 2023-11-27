<?php
$requestUri = $_SERVER['REQUEST_URI'];
if ($requestUri === '/registrate') {
    require_once './handler/registrate.php';
} elseif ($requestUri === '/login') {
    require_once './handler/login.php';
} elseif ($requestUri === '/main') {
    require_once './handler/main.php';
} elseif ($requestUri === '/add-product') {
    require_once './handler/add-product.php';
} else {
    echo 'not found';
}

