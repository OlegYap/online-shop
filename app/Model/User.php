<?php

class User extends Database
{
    public function create(string $name, string $email,string $password): array|bool
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
       return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
    public function getOne($login)
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email=:email');
        $stmt->execute(['email' => $login]);
        return $stmt->fetch();
    }
    public function getAll(): bool|array
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $this->pdo->prepare('SELECT * FROM users');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
