<?php
use Request\Request;
use Service\LoggerService;

class App
{
    private Container $container;
    private LoggerService $loggerService;
    private array $routes = [];


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

                $obj = $this->container->get($class);

                if (isset($handler['request'])) {
                    $requestClass = $handler['request'];
                    $request = new $requestClass($requestMethod, $_POST);
                } else {
                    $request = new Request($requestMethod, $_POST);
                }

                try {
                    $obj->$method($request);
                } catch (Error $error) {
                    $this->loggerService->error($error);
                    require_once '../View/error500.html';
                }

            } else {
                echo "Метод $requestMethod для $requestUri не поддерживается";
            }
        }
    }
    public function get(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['GET'] =
            [
                'class' => $className,
                'method' => $method,
                'request' => $request,
            ];
    }

    public function post(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['POST'] =
            [
                'class' => $className,
                'method' => $method,
                'request' => $request,
            ];
    }

    public function put(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['PUT'] =
            [
                'class' => $className,
                'method' => $method,
                'request' => $request,
            ];
    }

    public function patch(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['PATCH'] =
            [
                'class' => $className,
                'method' => $method,
                'request' => $request,
            ];
    }

    public function setContainer(Container $container): void
    {
        $this->container = $container;
        $this->LoggerService = $container->get(LoggerService::class);
    }
}