<?php
class MySqlPDOConnection implements SingletonConnection{
    private static $instace;
    private $pdo;
    private $databaseHost;
    private $databaseName;
    private function __construct()
    {
    }
    static function  getInsatace(): SingletonConnection{
        if(self::$instace == null){
            self::$instace = new MySqlPDOConnection();
        }
        return self::$instace;
    } 
    function createDatabaseConnection(){
        try {

            $this->databaseHost = $_ENV['DB_SERVER_NAME'];
            $this->databaseName = $_ENV['DB_NAME'];

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