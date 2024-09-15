<?php

use Predis\Client;

Predis\Autoloader::register();
class RedisConnection implements DatabaseConnection {
    private Client $redis;
    function __construct()
    {
        $this->redis = new Predis\Client(array(
            "scheme" => "tcp",
            "host" => "127.0.0.1",
            "port" => 6379,
            "password" => "")
        );
    }
    function getConnection(): Client{
        return $this->redis;
    }
}
