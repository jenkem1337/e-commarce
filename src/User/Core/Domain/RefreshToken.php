<?php

class RefreshToken extends BaseEntity implements RefreshTokenInterface {
    private $userUuid;
    private $token;
    private $tokenExpireTime;

    function __construct($uuid, $userUuid, $createdAt, $updatedAt){
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$userUuid){
            throw new NullException('user'); 
        }
        $this->userUuid = $userUuid;
        
    }
    static function newInstance($uuid, $userUuid, $createdAt, $updatedAt):RefreshTokenInterface {
        try {
            return new RefreshToken($uuid, $userUuid, $createdAt, $updatedAt);
        } catch (\Throwable $th) {
            return new NullRefreshToken();
        }
    }

    static function newStrictInstance($uuid, $userUuid, $createdAt, $updatedAt):RefreshTokenInterface {
        return new RefreshToken($uuid, $userUuid, $createdAt, $updatedAt);
    }
    function createRefreshToken($expireTime){
        $this->token = password_hash(bin2hex(random_bytes(16)),PASSWORD_DEFAULT);
        if(!$expireTime){ 
            throw new NullException('expire'); 
        }
        $this->tokenExpireTime = $expireTime;
    }

    function setRefreshToken($refToken){
        if(!$refToken){ 
            throw new NullException('refresh token'); 
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