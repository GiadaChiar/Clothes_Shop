<?php


namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private string $host;
    private string $db_name;
    private string $username;
    private string $password;
    private string $charset;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';
    }

    public function getConnection(): PDO
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";

            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $e) {
            throw new \RuntimeException("DB connection failed: " . $e->getMessage());
        }
    }
}
