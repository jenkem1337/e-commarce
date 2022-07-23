<?php
interface AuthService{
    function login(UserLoginDto $userLoginDto):ResponseViewModel;
    function register(UserCreationalDto $userCreationalDto):ResponseViewModel;
    function verifyUserAccount(EmailVerificationDto $emailVerificationDto):ResponseViewModel;
    function refreshToken(RefreshTokenDto $refDto):ResponseViewModel;
    function sendChangeForgettenPasswordEmail(ForgettenPasswordEmailDto $forgettenPasswordMailDto):ResponseViewModel;
}