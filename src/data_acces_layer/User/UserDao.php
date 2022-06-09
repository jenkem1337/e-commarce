<?php

interface UserDao{
    function findUserByEmail($email);
    function save(User $user);
    function findUserByActivationCode($code);
    function updateUserActivatedState(User $user);

}