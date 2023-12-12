<?php
namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
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
            if (isset($_SESSION['user-id'])) {
                $userId = $_SESSION['user-id'];
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
        $cartProducts = CartProduct::getAllByCartId($userId);
        $productsIds = [];
        foreach ($cartProducts as $cartProduct) {
            $productsIds[] = $cartProduct->getProductId;
        }
        $products = Product::getByIds($productsIds);
        require_once '../View/cart.phtml';
    }
}