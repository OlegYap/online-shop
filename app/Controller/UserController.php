<?php
namespace Controller;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Model\User;
use Service\Authentication\AuthenticationInterface;

class UserController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function getRegistrateForm()
    {
        require_once '../View/registrate.phtml';
    }

    public function postRegistrate(RegistrateRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $requestData = $request->getBody();
            $name = $requestData['name'];
            $email = $requestData['email'];
            $password = $requestData['psw'];
            $hash = password_hash($password, PASSWORD_DEFAULT);

            User::create($name, $email, $hash);

            header('location: /login');
        }
        require_once '../View/registrate.phtml';
    }

    public function getLogin(): void
    {
        require_once '../View/login.phtml';
    }

    public function postLogin(LoginRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $requestData = $request->getBody();
            $login = $requestData['email'];
            $password = $requestData['psw'];
            $result = $this->authenticationService->login($login,$password);
            if ($result) {
                header('location: /main');
            }
            $errors['email'] = 'Неправильный логин или пароль';
        }
        require_once '../View/login.phtml';
    }
}