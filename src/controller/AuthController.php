<?php
require './vendor/autoload.php';
class AuthController {
    private AuthService $authService;

    function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    function login(){}

    function register(){}
}