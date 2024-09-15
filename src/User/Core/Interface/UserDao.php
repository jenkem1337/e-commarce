<?php

interface UserDao{
    function findUserByEmail($email);
    function persist(User $user);
    function findUserByActivationCode($code);
    function updateUserActivatedState(User $user);
    function findUserByUuid($userUuid);
    function updatePassword(User $user);
    function updateForgettenPasswordCode(User $user);
    function findUserByForgettenPasswordCode($passwordCode);
    function findAllWithPagination($startingLimit, $perPageForUsers);
    function updateFullName(User $user);
}