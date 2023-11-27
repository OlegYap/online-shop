<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {
    function validate($data)
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

    $errors = validate($_POST);

    if (empty($errors)) {
        $login = $_POST['email'];
        $password = $_POST['psw'];

        $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
        $stmt->execute(['email' => $login]);

        $data = $stmt->fetch();
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
    }
}

require_once './html/login.phtml';
