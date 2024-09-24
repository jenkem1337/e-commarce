<?php
class MySqlPDOConnection implements DatabaseConnection {
    private static $instance;
    private $pdo;
    private $databaseHost;
    private $databasePort;
    private $databaseName;
    private $databaseUser;
    private $databasePassword;

    private function __construct() {
        $this->databaseHost = $_ENV['DB_SERVER_NAME'];
        $this->databasePort = $_ENV['DB_SERVER_PORT'];
        $this->databaseName = $_ENV['DB_NAME'];
        $this->databaseUser = $_ENV['DB_USER'];
        $this->databasePassword = $_ENV['DB_PASSWORD'];
    }

    public static function getInstance(): DatabaseConnection {
        if (self::$instance == null) {
            self::$instance = new MySqlPDOConnection();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        if ($this->pdo == null) {
            try {
                $this->pdo = new PDO("mysql:host=$this->databaseHost;dbname=$this->databaseName;port=$this->databasePort", $this->databaseUser, $this->databasePassword);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                throw $e;
            }
        }
        return $this->pdo;
    }
}
