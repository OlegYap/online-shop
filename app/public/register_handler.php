<?php

$protect = 'Ошибка!';

$name = $_POST['name'];
if (strlen($name) < 2)
{
    echo "Имя должно быть больше 2 символов";
}

echo "<br>";

$email = $_POST['email'];
if (strlen($email) < 4)
{
    echo "Почта должна быть больше 4 символов";
}

echo "<br>";

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Неверный формат электронной почты";
}

echo "<br>";

$password = $_POST['psw'];

$passwordR = $_POST['psw-repeat'];
if ($password !== $passwordR){
    echo "Пароли не совпадают";
}


$pdo = new PDO("pgsql:host=db;dbname=postgres","dbuser","dbpwd");

$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
$stmt->execute(['name' => $name,  'email' => $email, 'password' => $password]);

$stmt = $pdo->prepare('SELECT * FROM users');
$stmt->execute();
$data= $stmt ->fetchAll();

$denied = 'Ошибка регистраций';
$success = 'Пользователь в бд';

if ($name && $email && $password == false) {
    echo $denied;
} else {
    return $success;
}

echo "<br>";
print_r($data);