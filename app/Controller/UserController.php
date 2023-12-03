<?php

class UserController
{
    public function registrate(array $requestData): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod === 'POST') {
            $errors =$this->validateRegistrate($requestData);

            if (empty($errors)) {
                $name = $requestData['name'];
                $email = $requestData['email'];
                $password = $requestData['psw'];

                require_once '../Model/User.php';

                //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

                /*$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
                $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);*/
                $userModel = new User();
                $data =$userModel->create( $name, $email, $password);

                /*$stmt = $pdo->prepare('SELECT * FROM users');
                $stmt->execute();
                $data = $stmt->fetchAll();*/
                $userModel = new User();
                $data = $userModel->getAll();

                header('location: /login');
            }
            require_once '../View/registrate.phtml';
        }
    }
    private function validateRegistrate(array $data): array
    {
        $errors = [];
        if (isset($data['name']))
        {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = 'Имя должно содержать больше двух букв';
            }
        } else {
            $errors['name'] = 'Введите имя';
        }

        if (isset($data['email']))
        {
            $email = $data['email'];
            if (strlen($email) < 4) {
                $errors['email'] = 'Электронная почта должна содержать больше 4 символов';
            } elseif (!strpos($email,'@')) {
                $errors['email'] = 'Некорректный формат почты';
            }
        } else {
            $errors['email'] = 'Введите email';
        }

        if (isset($data['psw-repeat'])) {
            $password = $data['psw'];
            $passwordR = $data['psw-repeat'];
            if ($password !== $passwordR) {
                $errors['psw'] = 'Пароль должен содержать больше 6 символов';
            }
        } else {
            $errors['psw'] = 'Введите пароль';
        }

        return $errors;
    }
    public function login(array $requestData): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($requestMethod === 'POST')
        {
            $errors = $this->validateLogin($requestData);

            if (empty($errors)) {
                $login = $requestData['email'];
                $password = $requestData['psw'];

                require_once '../Model/User.php';

                $userModel = new User();
                $data = $userModel->getOne($login);

                if (empty($data)) {
                    $errors['login'] = 'Логин или пароль введен неверно';
                } else {
                    if ($password === $data['password']) {
                        //setcookie('user_id', $data['id']);
                        //Выдаем уникальный идентификатор сессии
                        session_start();
                        $_SESSION['user_id'] = $data['id'];
                        header('location: /main');
                    } else {
                        $errors['login'] = 'Логин или пароль введен неверно';
                    }
                }
                require_once '../View/login.phtml';
            }
        }
    }
    private function validateLogin(array $data): array
    {
        $errors = [];
        if (isset($data['email'])) {
            $login = $data['email'];
            if (empty($login)) {
                $errors ['login'] = 'Заполните поле Login';
            } elseif (!strpos($login, '@')) {
                $errors['login'] = "Некорректный формат почты";
            }
        } else {
            $errors['login'] = 'Заполните поле Login';
        }
        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (empty($password)) {
                $errors['psw'] = 'Введите пароль';
            }
        } else {
            $errors['psw'] = 'Введите пароль';
        }
        return $errors;
    }
}