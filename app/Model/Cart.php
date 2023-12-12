<?php
namespace Model;
use PDO;

class Cart extends Model
{
    private int $id;
    private string $name;
    private int $userId;

    public function __construct(int $id, string $name, int $userId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public static function getOneByUserId(int $userId): Cart|null
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        $stmt = self::getPDO()->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($data))
        {
            return null;
        }

        return new self($data['userId'],$data['id'], $data['name']);
    }


    public static function create(int $userId): bool
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = self::getPDO()->prepare(query: 'INSERT INTO carts ( name, user_id) VALUES (:name, :id)');
        return $stmt->execute(['name' => 'cart', 'id' => $userId]);
    }
}