<?php
interface SingletonConnection extends DatabaseConnection {
    function createDatabaseConnection();
}