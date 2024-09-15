<?php

abstract class AuthServiceDecorator implements AuthService {
    private AuthService $authService;
    function __construct(AuthService $service)
    {
        $this->authService = $service;
    }
    function login(UserLoginDto $userLoginDto):ResponseViewModel{
        return $this->authService->login($userLoginDto);
    }
    function register(UserCreationalDto $userCreationalDto):ResponseViewModel{
        return $this->authService->register($userCreationalDto);
    }
    function verifyUserAccount(EmailVerificationDto $emailVerificationDto):ResponseViewModel{
        return $this->authService->verifyUserAccount($emailVerificationDto);
    }
    function refreshToken(RefreshTokenDto $refDto):ResponseViewModel{
        return $this->authService->refreshToken($refDto);
    }
    function sendChangeForgettenPasswordEmail(ForgettenPasswordEmailDto $forgettenPasswordMailDto):ResponseViewModel{
        return $this->authService->sendChangeForgettenPasswordEmail($forgettenPasswordMailDto);
    }

}