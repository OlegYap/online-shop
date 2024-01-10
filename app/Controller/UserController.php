<?php
namespace Controller;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Model\User;

class UserController
{
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
            $passwordR = $requestData['psw-repeat'];
            $hash = password_hash($password, PASSWORD_DEFAULT);

            User::create($name, $email, $hash);

            $requestData = User::getOneByLogin($name);

            header('location: /login');
        }
        require_once '../View/registrate.phtml';
    }

    public function getLogin()
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
                $requestData = User::getOneByLogin($login);

                if (empty($requestData)) {
                    $errors['login'] = 'Логин или пароль введен неверно';
                } else {
                    if (password_verify($password, $requestData->getPassword())) {
/*                        setcookie('user_id', $data['id']);*/
                        session_start();
                        $_SESSION['user_id'] = $requestData->getId();
                        header('location: /main');
                    } else {
                        $errors['password'] = 'Логин или пароль введен неверно';
                    }
                }

            }
        require_once '../View/login.phtml';
    }
}