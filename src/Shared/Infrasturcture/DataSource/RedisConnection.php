<?php

use Predis\Client;

Predis\Autoloader::register();
class RedisConnection implements DatabaseConnection {
    private Client $redis;
    function __construct()
    {
        $this->redis = new Predis\Client(array(
            "scheme" => "tcp",
            "host" => $_ENV['REDIS_HOST'],
            "port" => (int) $_ENV['REDIS_PORT'],
            "password" => "")
        );
    }
    function getConnection(): Client{
        return $this->redis;
    }
}
