<?php

require "./vendor/autoload.php";
class UserRepositoryAggregateRootDecorator extends UserRepositoryDecorator{

    function findUserByEmail($userMail):UserInterface{
        return parent::findUserByEmail($userMail);
    }
    function persistUser(AggregateRoot $user){
        parent::persistUser($user);
    }
    function findUserByVerificationCode($code):UserInterface{
        return parent::findUserByVerificationCode($code);
    }
    function updateUserActivatedState(AggregateRoot $user){
        parent::updateUserActivatedState($user);
    }
    function persistRefreshToken(AggregateRoot $user){
        parent::persistRefreshToken($user);
    }
    function findUserByUuidWithRefreshToken($refreshToken):UserInterface{
        return parent::findUserByUuidWithRefreshToken($refreshToken);
    }
    function updatePassword(AggregateRoot $user){
        parent::updatePassword($user);
    }
    function updateForgettenPasswordCode(AggregateRoot $user){
        parent::updateForgettenPasswordCode($user);
    }
    function findUserByForgettenPasswordCode($passwordCode):UserInterface{
        return parent::findUserByForgettenPasswordCode($passwordCode);
    }
    function findAllWithPagination($startingLimit, $perPageForUsers, UserCollection $u):IteratorAggregate{
        return parent::findAllWithPagination($startingLimit, $perPageForUsers, $u);
    }
    function findOneUserByUuid($uuid):UserInterface{
        return parent::findOneUserByUuid($uuid);
    }
    function updateFullName(AggregateRoot $user){
        parent::updateFullName($user);
    }

}