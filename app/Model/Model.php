<?php
namespace Model;
class Model
{
    protected static PDO $pdo;

    public static function getPDO()
    {
        if (isset(self::$pdo)){
            return self::$pdo;
        }
        self::$pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");

        return self::$pdo;
    }
}