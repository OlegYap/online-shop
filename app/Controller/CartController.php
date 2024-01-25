<?php
namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
class CartController
{
    public function postAddProduct(AddProductRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            session_start();
            $requestData = $request->getBody();
            $productId = $requestData['product_id'];
            $quantity = $requestData['quantity'];

            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $cart = Cart::getOneByUserId($userId);

                if (!isset($cart)) {
                    Cart::create($userId);
                    $cart = Cart::getOneByUserId($userId);
                }
                //$cartId = $cart->getId();
                CartProduct::create($cart->getId(), $productId, $quantity);
                header('location: /main');
            } else {
                header('location: /login');
            }
        }
    }
    public function getCartPage(): void

    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $cart = Cart::getOneByUserId($userId);
            if (isset($cart)) {
                $cartId = $cart->getId();
                $cartProducts = CartProduct::getAllByCartId($cartId);
                if (isset($cartProducts)) {
                    $productIds = [];

                    foreach ($cartProducts as $cartProduct) {
                        $productIds[] = $cartProduct->getProductId();
                    }
                    $products = Product::getByIds($productIds);
                    require_once '../View/cart.phtml';
                } else {
                    header('location: /login');
                }
             }
        }
    }
}