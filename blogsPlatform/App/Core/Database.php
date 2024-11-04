<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private PDO $pdo;

    /**
     * Конструктор для инициализации подключения к базе данных.
     */
    public function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';
        $db = $config['db'];

        $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8mb4";
        
        try {
            $this->pdo = new PDO($dsn, $db['user'], $db['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }

    /**
     * Получает экземпляр PDO.
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    // Метод для подготовки запросов
    public function prepare($query)
    {
        return $this->pdo->prepare($query); // Используем $this->pdo вместо $this->connection
    }
}
