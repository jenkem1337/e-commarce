<?php

require "./vendor/autoload.php";
class UserRepositoryAggregateRootDecorator extends UserRepositoryDecorator{

    function findUserByEmail($userId){
        return parent::findUserByEmail($userId);
    }
    function save(AggregateRoot $user){
        parent::save($user);
    }
    function findUserByVerificationCode($code){
        return parent::findUserByVerificationCode($code);
    }
    function updateUserActivatedState(AggregateRoot $user){
        parent::updateUserActivatedState($user);
    }
    function saveRefreshToken(AggregateRoot $user){
        parent::saveRefreshToken($user);
    }
    function findUserByUuidWithRefreshToken($refreshToken){
        return parent::findUserByUuidWithRefreshToken($refreshToken);
    }
    function updatePassword(AggregateRoot $user){
        parent::updatePassword($user);
    }
    function updateForgettenPasswordCode(AggregateRoot $user){
        parent::updateForgettenPasswordCode($user);
    }
    function findUserByForgettenPasswordCode($passwordCode){
        return parent::findUserByForgettenPasswordCode($passwordCode);
    }
    function findAllWithPagination($startingLimit, $perPageForUsers){
        return parent::findAllWithPagination($startingLimit, $perPageForUsers);
    }
    function findOneUserByUuid($uuid){
        return parent::findOneUserByUuid($uuid);
    }
    function updateFullName(AggregateRoot $user){
        parent::updateFullName($user);
    }

}