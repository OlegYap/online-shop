<?php
namespace Controller;
use Model\Product;

class MainController
{
    public function getMain()
    {
        require_once '../View/main.phtml';
    }
    public function postMainPage(): void
    {
        session_start();
        if (isset($_SESSION->getUserId)) {
           // require_once '../Model/Product.php';
            //$mainModel = new Product();
           $products = Product::getAll();
        } else {
            header('location: /login');
        }
        require_once '../View/main.phtml';
    }
}
