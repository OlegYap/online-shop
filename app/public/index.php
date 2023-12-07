<?php
use Controller\CartController;
use Controller\UserController;
use Controller\MainController;
use Request\Request;

$requestUri = $_SERVER['REQUEST_URI'];
$autoload = function (string $classname)
{
    $path = str_replace('\\','/',$classname);
    $path = dirname(__DIR__) . "/" . $path . ".php";

    if (file_exists($path))
    {
        require_once $path;
    }
};

spl_autoload_register($autoload);

$routes = [
    '/login' => [
        'class' => UserController::class,
        'method' => 'login',
    ],
    '/registrate' => [
        'class' => UserController::class,
        'method' => 'registrate',
    ],
    '/main' => [
        'class' => MainController::class,
        'method' => 'main',
    ],
    '/add-product' => [
        'class' => CartController::class,
        'method' => 'add-product'
    ]
];
$requestUri = $_SERVER['REQUEST_URI'];

if (isset($routes[$requestUri]))
{
    $handler = $routes[$requestUri];
    $class = $handler['class'];
    $method = $handler['method'];

    $obj = new $class();
    $method = $_SERVER["REQUEST_METHOD"];
    $request = new Request($method);
    $request->setBody($_POST);

    $obj->$method($request);
} else {
    echo 'Not Found';
}

/*if ($requestUri === '/login') {
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
}*/