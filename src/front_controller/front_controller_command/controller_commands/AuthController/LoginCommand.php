<?php

require './vendor/autoload.php';

class LoginCommand implements Command{
    private AuthController $authController;
    private Middleware $firstMiddleware;

    function __construct(AuthController $authController, Middleware $firstMiddleware)
    {
        $this->$authController = $authController;
        $this->firstMiddleware = $firstMiddleware;
    }

    function process($params = []){
        $this->firstMiddleware->check();
        return $this->authController->login();
    }
}