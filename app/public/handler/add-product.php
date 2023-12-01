<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
function validate(array $data): array
{
    $errors = [];
    if (isset($data['product-id'])) {
        $productId = $data['product-id'];
        if ($productId === '') {
            $errors['product-id'] = 'Введите номер товара';
        } elseif ($productId < 0) {
            $errors['product-id'] = 'Введите корректный номер товара';
        }
    } else {
        $errors['product-id'] = 'Введите номер';
    }

    if (isset($data['quantity'])) {
        $quantity = $data['quantity'];
        if ($quantity === '') {
            $errors['quantity'] = 'Введите корректные значения';
        } elseif ($quantity < 0){
            $errors['quantity'] = 'Введите корректное значение';
        }
    } else {
        $errors['quantity'] = 'Введите количество';
    }

    return $errors;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validate($_POST);

    if (empty($errors)) {
        $productId = $_POST['product-id'];
        $quantity = $_POST['quantity'];

        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

            if (empty($cart)) {
                $stmt = $pdo->prepare(query: 'INSERT INTO carts ( name, user_id) VALUES (:name, :id)');
                $stmt->execute(['name' => 'cart', 'id' => $userId]);

                $stmt = $pdo->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
                $stmt->execute(['userId' => $userId]);
                $cart = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            $cartId = $cart['id'];
            $stmt = $pdo->prepare(query: 'INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)');
            $stmt->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
            header('location: /main');
        }
    }
}
require_once './html/main.phtml';