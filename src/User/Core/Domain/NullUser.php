<?php

class NullUser implements UserInterface {
    function __construct()
    {
    }
    function isNull(){
        return true;
    }
    public function getUuid(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}

    function changeFullName($newFullname){}

    function hashPassword($userPassword){}

    function createNewPassword($newPassword){}

    function ChangePassword($oldPassword,$newPassword){}

    function comparePassword($fromBody):bool{return false;}

    function isUserActiveted(){}

    function createForgettenPasswordCode(){}

    function createActivationCode(){}

    function setActivationCode($code){}
    function setRefreshToken(RefreshTokenInterface $refreshToken){}

    function createRefreshTokenModel(){}

    public function setUserRole($userRole){}

    function getRefreshTokenModel(){}

    public function getFullname(){}

    public function getEmail(){}

    public function getPassword(){}

    public function getActivationCode(){}

    public function getUserRole(){}

    function getForegettenPasswordCode(){}

    public function getIsUserActiveted(){}

}