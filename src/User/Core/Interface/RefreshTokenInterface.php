<?php

interface RefreshTokenInterface {
        function createRefreshToken($expireTime);

        function setRefreshToken($refToken);
    
        function getExpireTime();
    
        function getRefreshToken();
    
        function getUserUuid();

        public function getUuid();

        public function getCreatedAt();
    
        public function getUpdatedAt();
    
        public function isNull();
    
}