<?php
use Controller\CartController;
use Controller\UserController;
use Controller\MainController;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Request\Request;

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
        'GET' => [
            'class' => UserController::class,
            'method' => 'getLogin',
        ],
        'POST' => [
            'class' => UserController::class,
            'method' => 'postLogin',
            'request' => LoginRequest::class
        ]
    ],
    '/registrate' => [
        'GET' => [
            'class' => UserController::class,
            'method' => 'getRegistrateForm',
        ],
        'POST' => [
            'class' => UserController::class,
            'method' => 'postRegistrate',
            'request' => RegistrateRequest::class
        ]
    ],
    '/main' => [
        'GET' => [
            'class' => MainController::class,
            'method' => 'getMain',
        ],
        'POST' => [
            'class' => MainController::class,
            'method' => 'postMain',
        ]
    ],
    '/add-product' => [
        'GET' => [
            'class' => CartController::class,
            'method' => 'getAddProduct'
        ],
        'POST' => [
            'class' => CartController::class,
            'method' => 'postAddProduct'
        ]
    ],
    '/cart' => [
        'GET' => [
            'class' => CartController::class,
            'method' => 'CartPage'
        ]
    ]
];
$requestUri = $_SERVER['REQUEST_URI'];
if (isset($routes[$requestUri])) {
    $routeMethods = $routes[$requestUri];
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if (isset($routeMethods[$requestMethod])) {
        $handler = $routeMethods[$requestMethod];
        $class = $handler['class'];
        $method = $handler['method'];

        // Проверка на наличие ключа "request"
        if (isset($handler['request'])) {
            $requestClass = $handler['request'];
            $request = new $requestClass($requestMethod, $_POST);
        } else {
            $request = new Request($requestMethod, $_POST);
        }

        $obj = new $class();
        $obj->$method($request);
    } else {
        echo "Метод $requestMethod для $requestUri не поддерживается";
    }
}
/*if (isset($routes[$requestUri])) {
    $routeMethods = $routes[$requestUri];
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if (isset($routeMethods[$requestMethod])) {
        $handler = $routeMethods[$requestMethod];
        $class = $handler['class'];
        $method = $handler['method'];
        $requestClass = $handler['request'];
        $obj = new $class();
        $request = new $requestClass($requestMethod, $_POST);

        //$request->setBody($_POST);
        $obj->$method($request);
    } else {
        echo "Метод $requestMethod для $requestUri не поддерживается";
    }
}*/

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