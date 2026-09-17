<?php

namespace App\Database;

use PDO;

class DB
{
    private readonly PDO $pdo;
    private static ?DB $_instance = null;

    private function __construct()
    {
        $host = $_ENV['DATABASE_HOST'];
        $port = $_ENV['DATABASE_PORT'];
        $name = $_ENV['DATABASE_NAME'];
        $username = $_ENV['DATABASE_USER'];
        $password = $_ENV['DATABASE_PASSWORD'];

        $this->pdo = new PDO(
            "mysql:host=$host;port=$port;dbname=$name;",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    public static function instance(): DB
    {
        if (!self::$_instance) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($sql): mixed
    {
        $statement = $this->pdo->query($sql);
        return $statement->fetchAll();
    }

    public function execute($sql): bool
    {
        $result = $this->pdo->exec($sql);
        return $result;
    }
}