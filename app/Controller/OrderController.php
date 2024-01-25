<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\Model;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Request\OrderRequest;
use Service\OrderService;

class OrderController
{
    public function getOrderForm(): void
    {
        require_once '../View/order.phtml';
    }

    public function postOrder(OrderRequest $request)
    {
        $errors = $request->validate();
        if (empty($errors)) {
            session_start();
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $requestData = $request->getBody();
                $name = $requestData['name'];
                $lastName = $requestData['lastname'];
                $phoneNumber = $requestData['phonenumber'];
                $address = $requestData['address'];


                OrderService::create($userId,$name,$lastName,$phoneNumber,$address);
/*
                $pdo = Model::getPDO();

                $pdo->beginTransaction();


                Order::create($userId, $name, $lastName, $phoneNumber, $address);

                $cart = Cart::getOneByUserId($userId);
                $cartId = $cart->getId();
                $cartProducts = CartProduct::getAllByCartId($cartId);


                $productIds = [];
                foreach ($cartProducts as $cartProduct) {
                    $productIds[] = $cartProduct->getProductId();
                }

                $products = Product::getByIds($productIds);
                foreach ($cartProducts as $cartProduct) {
                    if (isset($products[$cartProduct->getProductId()]))
                    {
                        $product = $products[$cartProduct->getProductId()];
                        $prices[$product->getId()] = $product->getPrice() * $cartProduct->getQuantity();
                    }
                }

                $orderId = Order::getOneByUserId($userId)->getId();
                OrderProduct::create($orderId, $cartProducts, $prices);
                CartProduct::clear($cartId);

                try {
                    Order::create($userId, $name, $lastName, $phoneNumber, $address);
                    $orderId = Order::getOneByUserId($userId)->getId();
                    OrderProduct::create($orderId, $cartProducts, $prices);
                    CartProduct::clear($cartId);
                } catch (\Throwable $exception) {
                    $pdo->rollBack();
                }
                $pdo->commit();*/

                header('location: /order-product');
            }
            require_once "../View/order.phtml";
        }
    }

    public function getOrder()
    {
        {
            session_start();
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $order = Order::getOneByUserId($userId);
                $orderId = $order->getId();
                $orderProducts = OrderProduct::getAllByOrderId($orderId);

                foreach ($orderProducts as $orderProduct) {
                    $productIds[] = $orderProduct->getProductId();
                }

                $products = Product::getByIds($productIds);
                require_once "../View/orderproduct.phtml";
            }
        }
    }
}