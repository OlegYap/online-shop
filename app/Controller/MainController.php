<?php
namespace Controller;
use Model\Product;

class MainController
{
    public function getMainPage(): void
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $products = Product::getAll();
        } else {
            header('location: /login');
        }
        require_once '../View/main.phtml';
    }
}
