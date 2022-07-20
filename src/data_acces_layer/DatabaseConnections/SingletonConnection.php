<?php
require './vendor/autoload.php';
interface SingletonConnection extends DatabaseConnection {
    function createDatabaseConnection();
}