<?php
$requestUri = $_SERVER['REQUEST_URI'];
if ($requestUri === '/registrate') {
    require_once "../Controller/UserController.php";
    $userController = new UserController();
    $userController->registrate();
} elseif ($requestUri === '/login') {
    require_once '../Controller/UserController.php';
} elseif ($requestUri === '/main') {
    require_once './handler/main.php';
} elseif ($requestUri === '/add-product') {
    require_once './handler/add-product.php';
} else {
    echo 'not found';
}

