<?php

class NullRefreshToken implements RefreshTokenInterface {
        function __construct()
        {
        }
        function isNull(){
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