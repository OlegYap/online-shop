<?php
namespace Controller;
use Model\Product;
use Service\Authentication\AuthenticationInterface;
use Service\Authentication\SessionAuthenticationService;

class MainController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }
    public function getMainPage(): void
    {
        $user = $this->authenticationService->getCurrentUser();
        if (empty($user)) {
            header('location: /login');
        }
        $products = Product::getAll();
        require_once '../View/main.phtml';
    }
}
