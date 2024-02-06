<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;

function  routes(App $app, $container): App
{
    $app->setContainer($container);

    $app->get('/registrate', UserController::class, 'getRegistrateForm');
    $app->post('/registrate', UserController::class, 'postRegistrate', RegistrateRequest::class);

    $app->get('/login', UserController::class, 'getLogin');
    $app->post('/login', UserController::class, 'postLogin', LoginRequest::class);


    $app->get('/main', MainController::class, 'getMainPage');
    $app->post('/add-product', CartController::class, 'postAddProduct', AddProductRequest::class);

    $app->get('/cart', CartController::class, 'getCartPage');

    $app->get('/order', OrderController::class, 'getOrderForm');
    $app->post('/order', OrderController::class, 'postOrder', OrderRequest::class);

    $app->get('/order-product', OrderController::class, 'getOrder');

    return $app;
}