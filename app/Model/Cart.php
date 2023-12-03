<?php
class Cart extends Database
{
    public function getOne(int $userId): array
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        $stmt = $this->pdo->prepare(query: 'SELECT * FROM carts WHERE user_id = :userId');
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(int $userId): bool
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $this->pdo->prepare(query: 'INSERT INTO carts ( name, user_id) VALUES (:name, :id)');
        return $stmt->execute(['name' => 'cart', 'id' => $userId]);
    }
}