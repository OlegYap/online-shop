<?php

class MainController
{
    public function MainPage(): void
    {
        require_once '../Model/Main.php';
        session_start();
        if (isset($_SESSION['user_id'])) {
            require_once '../Model/Main.php';
            $mainModel = new Main();
            $products = $mainModel->getAll();
        } else {
            header('location: /login');
        }
        require_once '../View/main.phtml';
    }
}