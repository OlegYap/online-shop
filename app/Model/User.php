<?php
namespace Model;
//use Model\Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(int $id,string $name,string $email,string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;

    }

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

    public static function create(string $name, string $email,string $password): array|bool
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = self::getPDO()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
       return $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
    public static function getOneByLogin($login): User|null
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = self::getPDO()->prepare('SELECT * FROM users WHERE email=:email');
        $stmt->execute(['email' => $login]);
        $data = $stmt->fetch();

        if (empty($data))
        {
            return null;
        }

        return new self($data['id'],$data['name'],$data['email'], $data['password']);
    }
    public static function getAll(): array|null
    {
        //$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
        $stmt = self::getPDO()->prepare('SELECT * FROM users');
        $stmt->execute();
        $data = $stmt->fetchAll();

        if (empty($data))
        {
            return null;
        }

        $users = [];
        foreach ($data as $obj) {
            $user = new self($obj['id'],$obj['name'],$obj['email'],$obj['password']);
            $users[] = $user;
        }
        return $users;
    }
}
