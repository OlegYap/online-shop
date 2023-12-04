<?php
require_once "../Model/Model.php";
class Cart extends Model
{
    private int $userId;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public static function getOneByUserId(PDO $pdo, int $userId): Cart
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        $stmt = $pdo->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $obj = new self($data['userId']);
        return $obj;
    }

    public function create(int $userId): bool
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $this->pdo->prepare(query: 'INSERT INTO carts ( name, user_id) VALUES (:name, :id)');
        return $stmt->execute(['name' => 'cart', 'id' => $userId]);
    }
}