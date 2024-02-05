<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
use Service\Authentication\AuthenticationInterface;
use Service\Authentication\SessionAuthenticationService;
use Service\OrderService;

require_once '../Autoloader.php';
Autoloader::registrate(dirname(__DIR__));

require_once '../Config/dependencies.php';
require_once '../Config/routes.php';

$container = depend(new Container());

$app = routes(new App(), $container);

$app->run();
