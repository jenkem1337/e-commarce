<?php
require '/xampp/htdocs/vendor/autoload.php';
class SqliteInMemoryConnection implements DatabaseConnection {
    private PDO $pdo;
    function __construct()
    {
        try {
            $this->pdo = new PDO('sqlite::memory:');
        } catch (\Exception $th) {
            echo $th->getMessage();
        }

    }
    function getConnection():PDO
    {
        return $this->pdo;
    }
}
