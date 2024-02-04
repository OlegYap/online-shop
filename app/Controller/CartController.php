<?php
namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
use Service\Authentication\AuthenticationInterface;
use Service\Authentication\SessionAuthenticationService;

class CartController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function postAddProduct(AddProductRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $user = $this->authenticationService->getCurrentUser();
            if (!empty($user)) {
                header('location: /login');
            }
            $requestData = $request->getBody();
            $userId = $user->getId();
            $productId = $requestData['product_id'];
            $quantity = $requestData['quantity'];
            $cart = Cart::getOneByUserId($userId);
            if (empty($cart)) {
                Cart::create($userId);
                $cart = Cart::getOneByUserId($userId);
            }
            CartProduct::create($cart->getId(), $productId, $quantity);
            header('location: /main');
        }
    }

    public function getCartPage(): void

    {
        $user = $this->authenticationService->getCurrentUser();
        if (empty($user)) {
            header('location: /login');
        }
        $cart = Cart::getOneByUserId($user->getId());
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
            }
        }
    }
}