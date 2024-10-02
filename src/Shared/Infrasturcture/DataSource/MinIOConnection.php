<?php
use Aws\S3\S3Client;

class MinIOConnection implements ObjectStorageConnection{
    private $connection;
    private static ?MinIOConnection $instance = null;
    private function __construct($conn){
        $this->connection = $conn;
    }
    static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new MinIOConnection(new S3Client([
                'version' => 'latest',
                'region'  => 'us-east-1',
                'endpoint' => $_ENV["OBJECT_STORAGE_HOST"].":".$_ENV["OBJECT_STORAGE_PORT"],
                'use_path_style_endpoint' => true,
                'credentials' => [
                  'key'    => $_ENV["OBJECT_STORAGE_KEY"],
                  'secret' => $_ENV["OBJECT_STORAGE_SECRET"]
                ],
            ]));
            return self::$instance;
        }
        return self::$instance;
    }
    function getConnection() {
        return $this->connection;
    }
}
