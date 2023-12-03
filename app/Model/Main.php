<?php
class Main extends Database
{
    public function getAll()
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres","dbuser","dbpwd");
        $stmt = $this->pdo->prepare('SELECT * FROM products');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}