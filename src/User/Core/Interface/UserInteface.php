<?php

interface UserInterface {
        function changeFullName($newFullname);

        function hashPassword($userPassword);
    
        function createNewPassword($newPassword);
    
        function ChangePassword($oldPassword,$newPassword);
    
        function comparePassword($fromBody):bool;
    
        function isUserActiveted();
    
        function createForgettenPasswordCode();
    
        function createActivationCode();
    
        function setActivationCode($code);
    
        function createRefreshTokenModel();
        function setRefreshToken(RefreshTokenInterface $refreshToken);
    
        public function setUserRole($userRole);
    
        function getRefreshTokenModel();
    
        public function getFullname();
    
        public function getEmail();
    
        public function getPassword();
    
        public function getActivationCode();
    
        public function getUserRole();
    
        function getForegettenPasswordCode();
    
        public function getIsUserActiveted();
        
        public function getUuid();

        public function getCreatedAt();
    
        public function getUpdatedAt();

        function isNull();
    
    
}