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

$container = new Container();
$container->set(OrderController::class, function (Container $container){
    $orderService = new OrderService();
    $authenticationSerivice = $container->get(AuthenticationInterface::class);
    return new OrderController($orderService,$authenticationSerivice);
});

$container->set(CartController::class, function (Container $container){
    $authenticationService = $container->get(AuthenticationInterface::class);
    return new CartController($authenticationService);
});

$container->set(MainController::class, function (Container $container) {
    $authenticationService = $container->get(AuthenticationInterface::class);

    return new MainController($authenticationService);
});

$container->set(UserController::class, function (Container $container) {
    $authenticationService = $container->get(AuthenticationInterface::class);

    return new UserController($authenticationService);
});

$container->set(AuthenticationInterface::class, function () {
    return new SessionAuthenticationService(); // Here we can change on Cookie Authentication Service
});

$app = new App();
$app->setContainer($container);

$app->get('/registrate', UserController::class, 'getRegistrateForm');
$app->post('/registrate', UserController::class, 'postRegistrate', RegistrateRequest::class);

$app->get('/login', UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'postLogin', LoginRequest::class);


$app->get('/main', MainController::class, 'getMainPage');
$app->post('/main', CartController::class, 'postAddProduct', AddProductRequest::class);

$app->get('/cart', CartController::class, 'getCartPage');

$app->get('/order', OrderController::class, 'getOrderForm');
$app->post('/order', OrderController::class, 'postOrder', OrderRequest::class);

$app->get('/order-product', OrderController::class, 'getOrder');

$app->run();
