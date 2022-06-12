<?php

interface UserRepository{
    function findUserByEmail($userId):User;
    function save(User $user);
    function findUserByVerificationCode($code):User;
    function updateUserActivatedState(User $user);
    function saveRefreshToken(User $user);
    function findUserByUuidWithRefreshToken($refreshToken);
    function updatePassword(User $user);
    function updateForgettenPasswordCode(User $user);
    function findUserByForgettenPasswordCode($passwordCode);
    function findAllWithPagination($startingLimit, $perPageForUsers);
    function findOneUserByUuid($uuid);
    function updateFullName(User $user);

}