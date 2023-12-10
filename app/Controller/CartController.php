<?php
namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
use Request\Request;
class CartController
{
    public function getAddProduct()
    {
        require_once '../View/main.phtml';
    }

    public function PostAddProduct(AddProductRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $requestData = $request->getBody();
            $productId = $requestData['product-id'];
            $quantity = $requestData['quantity'];
            session_start();
            if (isset($_SESSION->getUserId)) {
                $userId = $_SESSION->getUserId;
                Cart::getOneByUserId($userId);

                if (empty($cart)) {
                    Cart::create($userId);
                    $cart = Cart::getOneByUserId($userId);
                }
                $cartId = $cart->getId();
                CartProduct::create($cartId, $productId, $quantity);
                header('location: /main');
            }
            require_once '../View/main.phtml';
        }
    }
    public function CartPage(AddProductRequest $request): void
    {
        session_start();
        $userId = $_SESSION['user-id'];
        $cart = Cart::getOneByUserId($userId);
        $cartId = $cart->getId();
        $cartProducts = CartProduct::GetAllByUserId($userId);
        $productsIds = [];
        foreach ($cartProducts as $cartProduct) {
            $productsIds[] = $cartProduct->getProductId;
        }
        $products = Product::getByIds($productsIds);
        require_once '../View/cart.phtml';
    }
}