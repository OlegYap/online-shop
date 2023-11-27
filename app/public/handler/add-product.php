<?php
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$pdo = new PDO("pgsql:host=db;dbname=postgres","dbuser","dbpwd");
$stmt = $pdo->prepare("INSERT INTO cart_products (product_id, quantity) VALUES (:product_id,:quantity)");
$stmt->execute(['product_id' => $product_id,  'quantity' => $quantity]);



require_once './html/add-product.phtml';