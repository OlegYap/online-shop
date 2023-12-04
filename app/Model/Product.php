<?php
require_once "../Model/Model.php";

class Product extends Model
{
    private int $id;
    private string $name;
    private float $price;
    private string $description;

    public function __construct(int $id, string $name, float $price, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }
    public static function getAll(PDO $pdo)
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres","dbuser","dbpwd");
        $stmt = $pdo->prepare('SELECT * FROM products');
        $stmt->execute();
        $data = $stmt->fetchAll();

        $products = [];
        foreach ($data as $product)
        {
            $product = new self($product['id'], $product['name'], $product['price'], $product['description']);
            $products = $product;
        }
        return $products;
    }
}