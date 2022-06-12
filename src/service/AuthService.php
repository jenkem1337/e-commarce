<?php
interface AuthService{
    function login(UserLoginDto $userLoginDto):UserLogedInResponseDto;
    function register(UserCreationalDto $userCreationalDto):UserCreatedResponseDto;
    function verifyUserAccount(EmailVerificationDto $emailVerificationDto):EmailSuccessfulyActivatedResponseDto;
    function refreshToken(RefreshTokenDto $refDto):RefreshTokenResponseDto;
    function sendChangeForgettenPasswordEmail(ForgettenPasswordEmailDto $forgettenPasswordMailDto):ForgettenPasswordEmailResponseDto;
}