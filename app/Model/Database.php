<?php

class Database
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
    }
}