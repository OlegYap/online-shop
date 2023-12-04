<?php
$requestUri = $_SERVER['REQUEST_URI'];

$autoload1 = function (string $classname)
{
    $path = "../Controller/$classname.php";
    if (file_exists($path))
    {
        require_once $path;
    }
};

$autoload2 = function (string $classname)
{
    $path = "../Model/$classname.php";
    if (file_exists($path))
    {
        require_once $path;
    }
};

spl_autoload_register($autoload1);
spl_autoload_register($autoload2);


if ($requestUri === '/login') {
    $userController = new UserController();
    $userController->login($_POST);
} elseif ($requestUri === '/registrate') {
    $userController = new UserController();
    $userController->registrate($_POST);
} elseif ($requestUri === '/main') {
    $mainController = new MainController();
    $mainController->mainPage();
} elseif ($requestUri === '/add-product') {
    $cartController = new CartController();
    $cartController->addProduct($_POST);
} else {
    echo 'Not Found';
}