<?php
namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
use Request\Request;
class CartController
{
    public function getAddProduct(): void
    {
        require_once '../View/main.phtml';
    }

    public function postAddProduct(AddProductRequest $request): void
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

    public function getPage(): void
    {
        session_start();
        $userId = $_SESSION['user-id'];
        $cart = Cart::getOneByUserId($userId);
        $cartId = $cart->getId();
        $cartProducts = CartProduct::getAllByUserId($userId);
        $productsIds = [];
        foreach ($cartProducts as $cartProduct) {
            $productsIds[] = $cartProduct->getProductId;
        }
        $products = Product::getByIds($productsIds);
        foreach ($cartProducts as $cartProduct) {
            $productId = $cartProduct->getProductId();
            $product = Product::getByIds($productId); // Получаем информацию о продукте по его ID
            $productName = $product->getName();
            $productPrice = $product->getPrice();
            $quantity = $cartProduct->getQuantity();
        }
    }
}