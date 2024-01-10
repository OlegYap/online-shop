<?php

use Controller\UserController;
use Controller\MainController;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Request\Request;

class App
{
    private array $routes = [
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
                'method' => 'getMainPage',
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'postAddProduct',
                'request' => AddProductRequest::class
            ]
        ],
            '/add-product' => [
                'GET' => [
                    'class' => UserController::class,
                    'method' => 'getAddProduct'
                ],
                'POST' => [
                    'class' => UserController::class,
                    'method' => 'postAddProduct',
                    'request' => AddProductRequest::class
                ],
           '/cart' => [
                'GET' => [
                    'class' => UserController::class,
                    'method' => 'getCartPage'
                ]
           ]
            ]
    ];
    // Обрабатываем входящие запросы
    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        if (isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];
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
    }
}