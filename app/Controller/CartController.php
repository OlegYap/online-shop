<?php
class CartController
{
    public function addProduct($requestData): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors =$this->validateAddProduct($requestData);
            if (empty($errors)) {
                $productId = $requestData['product-id'];
                $quantity = $requestData['quantity'];

                session_start();
                if (isset($_SESSION->getUserId)) {
                    $userId = $_SESSION->getUserId;

                    //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

                    Cart::getOneByUserId($userId);

                    if (empty($cart)) {
                        /*$stmt = $pdo->prepare(query: 'INSERT INTO carts ( name, user_id) VALUES (:name, :id)');
                        $stmt->execute(['name' => 'cart', 'id' => $userId]);*/
                        //$cartModel = new Cart();
                        Cart::create($userId);

                        //$data = Cart::getOneByUserId($userId);

                        $cart = Cart::getOneByUserId($userId);
                        //$cart = $cartModel->getOneByUserId($userId);

                        //$stmt = $pdo->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
                        //$stmt->execute(['userId' => $userId]);
                        //$cart = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    $cartId = $cart->getId();
                    //$cartProductModel = new CartProduct();
                    CartProduct::create($cartId, $productId, $quantity);

                    //$stmt = $pdo->prepare(query: 'INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)');
                    //$stmt->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
                    header('location: /main');
                }
                require_once '../View/main.phtml';
            }
        }
    }
    private function validateAddProduct(array $data): array
    {
        $errors = [];
        if (isset($data['email'])) {
            $login = $data['email'];
            if (empty($login)) {
                $errors ['login'] = 'Заполните поле Login';
            } elseif (!strpos($login, '@')) {
                $errors['login'] = "Некорректный формат почты";
            }
        } else {
            $errors['login'] = 'Заполните поле Login';
        }
        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (empty($password)) {
                $errors['psw'] = 'Введите пароль';
            }
        } else {
            $errors['psw'] = 'Введите пароль';
        }
        return $errors;
    }
}