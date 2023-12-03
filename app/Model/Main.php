<?php
class Main
{
    public function getAll()
    {
        $pdo = new PDO("pgsql:host=db;dbname=postgres","dbuser","dbpwd");
        $stmt = $pdo->prepare('SELECT * FROM products');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}