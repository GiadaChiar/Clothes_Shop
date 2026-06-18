<?php
//database configuration
/*
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Database
{

    //how to enter 
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
    public $conn;

    //Connect to database


    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'] ?? '';
        $this->db_name = $_ENV['DB_NAME'] ?? '';
        $this->username= $_ENV['DB_USER'] ?? '';
        $this->password = $_ENV['DB_PASSWORD'] ?? '';
        $this->charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';
        

    }



    public function getConnection()
    {

        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";

            $this->conn = new PDO(
                $dsn,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {

            die("Database connection error: " . $exception->getMessage());
        }
        return $this->conn;
    }
}



$db = new Database();
$conn = $db->getConnection();
*/

?>
