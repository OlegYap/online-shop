<?php
namespace Controller;
use Model\Product;

class MainController
{
    public function getMainPage(): void
    {
        session_start();
        //echo 'getMainPage';
        //print_r($_SESSION);

        if (isset($_SESSION['user_id'])) {
            $products = Product::getAll();
            //print_r($products);
            require_once '../View/main.phtml';
        } else {
            header('location: /login');
        }
/*        require_once '../View/main.phtml';*/
    }
}
