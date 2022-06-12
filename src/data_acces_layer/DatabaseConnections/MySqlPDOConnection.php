<?php
require './vendor/autoload.php';


class MySqlPDOConnection implements DatabaseConnection{
    private $pdo;
    private $databaseHost;
    private $databaseName;
    function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable("C:\\xampp\htdocs\\");
        $dotenv->load();

        $this->databaseHost = $_ENV['DB_SERVER_NAME'];
        $this->databaseName = $_ENV['DB_NAME'];

        try {

            $this->pdo = new PDO("mysql:host=$this->databaseHost;dbname=$this->databaseName",'root','');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        } catch (PDOException $e) {
            echo json_encode(["pdo-error"=> $e->getMessage()]);
        }

    }
    function getConnection():PDO
    {
        return $this->pdo;
    }
}