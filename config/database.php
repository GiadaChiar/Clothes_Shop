<?php
//database configuration
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
    public $conn;

    //Connect to database


    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'] ?? '';
        $this->db_name = $_ENV['DB_NAME'] ?? '';
        $this->username= $_ENV['DB_USER'] ?? '';
        $this->password = $_ENV['DB_PASSWORD'] ?? '';
        

    }



    public function getConnection()
    {

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");

        } catch (PDOException $exception) {

            die("Database connection error: " . $exception->getMessage());
        }
        return $this->conn;
    }
}



$db = new Database();
$conn = $db->getConnection();


?>
