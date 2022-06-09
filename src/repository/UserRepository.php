<?php

interface UserRepository{
    function findUserByEmail($userId);
    function save(User $user);
    function findUserByVerificationCode($code);
    function updateUserActivatedState(User $user);
}