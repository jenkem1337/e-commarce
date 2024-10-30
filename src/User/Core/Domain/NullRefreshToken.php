<?php

class NullRefreshToken implements RefreshTokenInterface, NullEntityInterface {
        function __construct()
        {
        }
        function isNull():bool{
            return true;
        }
        function createRefreshToken($expireTime){}

        function setRefreshToken($refToken){}
    
        function getExpireTime(){}
    
        function getRefreshToken(){}
    
        function getUserUuid(){}

        public function getUuid(){}

        public function getCreatedAt(){}
    
        public function getUpdatedAt(){}
    
    
}