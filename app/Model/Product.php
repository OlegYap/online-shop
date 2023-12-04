<?php
require_once "../Model/Model.php";

class Product extends Model
{
    public static function getAll(PDO $pdo)
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres","dbuser","dbpwd");
        $stmt = $pdo->prepare('SELECT * FROM products');
        $stmt->execute();
        $data = $stmt->fetchAll();

        $products = [];
        foreach ($data as $obj)
        {
            $arr = new self();
            $products = $arr;
        }
        return $products;
    }
}