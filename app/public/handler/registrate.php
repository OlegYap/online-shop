<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod === 'POST') {
    function validate(array $data)
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

    $errors = validate($_POST);


    if (empty($errors))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['psw'];


        $pdo = new PDO("pgsql:host=db;dbname=postgres","dbuser","dbpwd");

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name,  'email' => $email, 'password' => $password]);

        $stmt = $pdo->prepare('SELECT * FROM users');
        $stmt->execute();
        $data= $stmt ->fetchAll();

        header('location: /login');
    }

}

require_once './html/registrate.phtml';


