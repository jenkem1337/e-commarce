<?php


class VerifyUserAccountCommand implements Command{
    private AuthController $authController;

    function __construct(AuthController $authController)
    {
        $this->authController = $authController;
    }

    function process($params = []){
        return $this->authController->verifyUserAccount();
    }
}