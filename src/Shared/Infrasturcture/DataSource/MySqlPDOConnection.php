<?php
class MySqlPDOConnection implements DatabaseConnection {
    private static $instance;
    private $pdo;
    private $databaseHost;
    private $databaseName;

    private function __construct() {
        $this->databaseHost = $_ENV['DB_SERVER_NAME'];
        $this->databaseName = $_ENV['DB_NAME'];
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
                $this->pdo = new PDO("mysql:host=$this->databaseHost;dbname=$this->databaseName", 'root', '');
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                throw $e;
            }
        }
        return $this->pdo;
    }
}
