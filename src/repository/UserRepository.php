<?php

interface UserRepository{
    function findUserByEmail($userMail):UserInterface;
    function persistUser(User $user);
    function findUserByVerificationCode($code):UserInterface;
    function updateUserActivatedState(User $user);
    function persistRefreshToken(User $user);
    function findUserByUuidWithRefreshToken($refreshToken):UserInterface;
    function updatePassword(User $user);
    function updateForgettenPasswordCode(User $user);
    function findUserByForgettenPasswordCode($passwordCode):UserInterface;
    function findAllWithPagination($startingLimit, $perPageForUsers):array;
    function findOneUserByUuid($uuid):UserInterface;
    function updateFullName(User $user);

}