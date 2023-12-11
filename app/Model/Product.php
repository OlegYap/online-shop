<?php
namespace Model;

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

    public static function getByIds(array $ids): array
    {
        $ids = implode(', ',$ids);
        $stmt = self::getPDO()->prepare('SELECT  FROM products WHERE id IN (:ids)');
        $stmt->execute(['id' => $ids]);
        $data = $stmt->fetchAll();
        $products = [];
        foreach ($data as $product)
        {
            $product[] = new self($product['id'], $product['name'], $product['price'], $product['description']);
        }
        return $products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public  function getName(): string
    {
        return $this->name;
    }

    public  function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public static function getAll(): array|Product
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres","dbuser","dbpwd");
        $stmt = self::getPDO()->prepare('SELECT * FROM products');
        $stmt->execute();
        $data = $stmt->fetchAll();

        $products = [];
        foreach ($data as $product)
        {
            $product[] = new self($product['id'], $product['name'], $product['price'], $product['description']);
            //$products[] = $product;
        }
        return $products;
    }
}