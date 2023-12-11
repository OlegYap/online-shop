<?php
namespace Controller;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Model\User;
class UserController
{
    public function getRegistrateForm(): void
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
                $passwordR = $requestData['psw-repeat'];
                User::create($name, $email, $password);
                User::getAll();

                header('location: /login');
            }
            require_once '../View/registrate.phtml';
    }

    public function getLogin()
    {
        require_once '../View/login.phtml';
    }

    public function postLogin(LoginRequest $requestData): void
    {
            $errors = $requestData->validate();

            if (empty($errors)) {
                $login = $requestData['email'];
                $password = $requestData['psw'];
                $requestData = User::getOneByLogin($login);

                if (empty($requestData)) {
                    $errors['login'] = 'Логин или пароль введен неверно';
                } else {
                    if ($password === $requestData->getPassword()) {
                        //setcookie('user_id', $data['id']);
                        //Выдаем уникальный идентификатор сессии
                        session_start();
                        $_SESSION['user_id'] = $requestData->getId();
                        header('location: /main');
                    } else {
                        $errors['login'] = 'Логин или пароль введен неверно';
                    }
                }
                require_once '../View/login.phtml';
            }
    }
}