<?php
session_start();
if (isset($_SESSION['user_id'])){
    //print_r($_SESSION['login']);
    // создаем соединение
    $pdo = new PDO("pgsql:host=db;dbname=postgres","dbuser","dbpwd");
    // выполняем запрос за продуктами
    $stmt = $pdo->prepare('SELECT * FROM products');
    $stmt->execute();
    // сохраняем в переменную данные о продуктах
    $products = $stmt->fetchAll();
    //print_r($products);
} else {
    header('Location: /login');
}

require_once './html/main.phtml';


