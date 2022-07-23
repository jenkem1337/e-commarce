<?php

class JwtPayloadDto {
    private static $instance;
    private $payload;
    private function __construct()
    {  
    }

    static function getInstance(){
        if(self::$instance == null){
            self::$instance = new JwtPayloadDto();
        }
        return self::$instance;
    }

    function setPayload($payload){
        $this->payload = $payload;
    }
    function getPayload(){
        return $this->payload;
    }
    function removePayload(){
        unset($this->payload);
    }
}