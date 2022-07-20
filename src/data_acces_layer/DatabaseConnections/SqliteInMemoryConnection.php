<?php
require '/xampp/htdocs/vendor/autoload.php';
class SqliteInMemoryConnection implements SingletonConnection {
    private static $instance;
    private PDO $pdo;
    private function __construct(){}
    static function getInstance():SingletonConnection{
        if(self::$instance == null){
            self::$instance = new SqliteInMemoryConnection();
        }
        return self::$instance;
    }
    function getConnection():PDO
    {
        return $this->pdo;
    }
	/**
	 *
	 * @return mixed
	 */
	function createDatabaseConnection() {
        {
            try {
                $this->pdo = new PDO('sqlite::memory:');
            } catch (\Exception $th) {
                echo $th->getMessage();
            }
    
        }
    
	}
}
