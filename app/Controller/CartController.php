<?php
class CartController
{
    public function addProduct(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors =$this->validateAddProduct($_POST);
            if (empty($errors)) {
                $productId = $_POST['product-id'];
                $quantity = $_POST['quantity'];

                session_start();
                if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id'];

                    require_once '../Model/Cart.php';


                    $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

                    $cartModel = new Cart();
                    $cart = $cartModel->getOne($userId);

                    if (empty($cart)) {
                        /*$stmt = $pdo->prepare(query: 'INSERT INTO carts ( name, user_id) VALUES (:name, :id)');
                        $stmt->execute(['name' => 'cart', 'id' => $userId]);*/

                        $cartModel = new Cart();
                        $cart = $cartModel->create($userId);


                        $cartModel = new Cart();
                        $cart = $cartModel->getOne($userId);

                        //$stmt = $pdo->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
                        //$stmt->execute(['userId' => $userId]);
                        //$cart = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    $cartId = $cart['id'];

                    require_once '../Model/CartProduct.php';


                    $cartProductModel = new CartProduct();
                    $cartProductModel->create($cartId, $productId, $quantity);

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