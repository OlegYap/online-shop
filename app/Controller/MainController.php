<?php
namespace Controller;
use Model\Product;

class MainController
{
    public function getMain(): void
    {
        require_once '../View/main.phtml';
    }
    public function postMainPage(): void
    {
        session_start();
        if (isset($_SESSION['user-id'])) {
           // require_once '../Model/Product.php';
            //$mainModel = new Product();
           $products = Product::getAll();
        } else {
            header('location: /login');
        }
        require_once '../View/main.phtml';
    }
}
