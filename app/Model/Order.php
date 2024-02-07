<?php

namespace Model;

use Core\Model;

class Order extends Model
{
    private int $id;
    private int $userId;
    private string $name;
    private string $lastName;
    private string $phoneNumber;
    private string $address;

    public function __construct(int $id, int $userId, string $name, string $lastName, string $phoneNumber, string $address)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
    }

    public static function create(int $userId, string $name, string $lastName, string $phoneNumber, string $address): array|bool
    {
        $stmt = self::getPDO()->prepare('INSERT INTO orders (user_id, name, lastname, phonenumber, address) VALUES (:user_id, :name, :lastname, :phonenumber, :address)');
        return $stmt->execute(['user_id' => $userId, 'name' => $name, 'lastname' => $lastName, 'phonenumber' =>$phoneNumber,'address' => $address ]);
    }

    public static function getOneByUserId(int $userId): Order|null
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM orders WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);

        $data = $stmt->fetch();

        if (empty($data)){
            return null;
        }

        return new self($data['id'], $data['user_id'], $data['name'], $data['lastname'], $data['phonenumber'],$data['address']);
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getId(): int
    {
        return $this->id;
    }
}