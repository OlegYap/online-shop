<?php
$requestUri = $_SERVER['REQUEST_URI'];
if ($requestUri === '/registrate') {
    require_once "../Controller/UserController.php";
    $userController = new UserController();
    $userController->registrate();
} elseif ($requestUri === '/login') {
    require_once "../Controller/UserController.php";
    $userController = new UserController();
    $userController->login();
} elseif ($requestUri === '/main') {
    require_once '../Controller/MainController.php';
    $userController = new MainController();
    $userController->MainPage();
} elseif ($requestUri === '/add-product') {
    require_once '../Controller/CartController.php';
    $userController = new CartController();
    $userController->addProduct();
}else {
    echo 'not found';
}

