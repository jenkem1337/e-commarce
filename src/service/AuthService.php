<?php
interface AuthService{
    function login(UserLoginDto $userLoginDto);
    function register(UserCreationalDto $userCreationalDto);
    function verifyUserAccount(EmailVerificationDto $emailVerificationDto);
}