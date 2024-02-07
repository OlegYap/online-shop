<?php

namespace Service;

use Core\Model;
use Model\Cart;
use Model\CartProduct;
use Model\Order;
use Model\OrderProduct;
use Model\Product;

class OrderService
{
    public static function create(int $userId, string $name, string $lastName, string $phoneNumber, string $address): void
    {
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


        $pdo = Model::getPDO();
        $pdo->beginTransaction();
        try {
            Order::create($userId, $name, $lastName, $phoneNumber, $address);
            $orderId = Order::getOneByUserId($userId)->getId();
            OrderProduct::create($orderId, $cartProducts, $prices);
            CartProduct::clear($cartId);
        } catch (\Throwable $exception) {
            $pdo->rollBack();
            $pdo->commit();
        }
    }

}