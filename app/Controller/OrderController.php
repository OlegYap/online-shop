<?php

namespace Controller;

use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Request\OrderRequest;
use Service\Authentication\AuthenticationInterface;
use Service\Authentication\SessionAuthenticationService;
use Service\OrderService;

class OrderController
{

    private OrderService $orderService;
    private AuthenticationInterface $authenticationService;

    public function __construct(OrderService $orderService, AuthenticationInterface $authenticationService)
    {
        $this->orderService = $orderService;
        $this->authenticationService = $authenticationService;
    }

    public function getOrderForm(): void
    {
        require_once '../View/order.phtml';
    }

    public function postOrder(OrderRequest $request)
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $user = $this->authenticationService->getCurrentUser();
            if (empty($user)) {
                header('location: /login');
            }
            $userId = $user->getId();
            $requestData = $request->getBody();
            $name = $requestData['name'];
            $lastName = $requestData['lastname'];
            $phoneNumber = $requestData['phonenumber'];
            $address = $requestData['address'];

            $orderSerivice = new OrderService;

            $this->orderService->create($userId,$name,$lastName,$phoneNumber,$address);
            header('location: /order-product');
        }
        require_once "../View/order.phtml";
    }

    public function getOrder()
    {
        {
            $user = $this->authenticationService->getCurrentUser();
            if (empty($user)) {
                header('location: /login');
            }
            $userId = $user->getId();
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