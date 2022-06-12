<?php

require "./vendor/autoload.php";
class RefreshToken extends BaseEntity {
    private $userUuid;
    private $token;
    private $tokenExpireTime;

    function __construct($uuid, $userUuid, $createdAt, $updatedAt){
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$userUuid){
            throw new Exception('user uuid must be not null'); 
        }
        $this->userUuid = $userUuid;
        
    }
    function createRefreshToken($expireTime){
        $this->token = password_hash(bin2hex(random_bytes(16)),PASSWORD_DEFAULT);
        if(!$expireTime){ 
            throw new Exception('expire time must be not null'); 
        }
        $this->tokenExpireTime = $expireTime;
    }

    function setRefreshToken($refToken){
        if(!$refToken){ 
            throw new Exception('refresh token must be not null'); 
        }
        $this->token = $refToken;
    }

    function getExpireTime(){
        return $this->tokenExpireTime;
    }
    function getRefreshToken(){
        return $this->token;
    }
    function getUserUuid(){
        return $this->userUuid;
    }
}