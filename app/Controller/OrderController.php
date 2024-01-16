<?php

namespace Controller;

use Request\OrderRequest;

class OrderController
{
    public function getOrder()
    {
        require_once '../View/cart.phtml';
    }

    public function postOrder(OrderRequest $request)
    {
        $errors = $request->validate();
        if (empty($errors)) {
            session_start();
            $requestData = $request->getBody();
            $name = $requestData['name'];
            $lastName = $requestData['lastname'];
            $phoneNumber = $requestData['phonenumber'];
            $address = $requestData['address'];


        }

    }
}