<?php
require_once "../Model/Model.php";

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function __construct(int $id,string $name,string $email,string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;

    }


    public function create(string $name, string $email,string $password): array|bool
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
       return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
    public static function getOneByLogin(PDO $pdo, $login): User
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
        $stmt->execute(['email' => $login]);
        $data = $stmt->fetch();

        $obj = new self($data['id'],$data['name'],$data['email'], $data['password']);

        return $obj;
    }
    public static function getAll(PDO $pdo): bool|array
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = $pdo->prepare('SELECT * FROM users');
        $stmt->execute();
        $data = $stmt->fetchAll();

        $users = [];
        foreach ($data as $obj) {
            $arr = new self($obj['id'],$obj['name'],$obj['email'],$obj['password']);
            $users = $arr;
        }
        return $users;
    }
}
