<?php
class MainController
{
    public function MainPage(): void
    {
        require_once '../Model/Product.php';
        session_start();
        if (isset($_SESSION['user_id'])) {
            require_once '../Model/Product.php';
            //$mainModel = new Product();
            $products = Product::getAll();
        } else {
            header('location: /login');
        }
        require_once '../View/main.phtml';
    }
}