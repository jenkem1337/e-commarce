<?php
require '/xampp/htdocs/vendor/autoload.php';
class SqliteInMemoryConnection implements DatabaseConnection {
    function getConnection()
    {
        try {
            $pdo = new PDO('sqlite::memory:');
            echo "bağlandı";
        } catch (\Exception $th) {
            echo $th->getMessage();
        }
    }
}
