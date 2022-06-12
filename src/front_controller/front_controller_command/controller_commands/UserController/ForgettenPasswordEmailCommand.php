<?php
require "./vendor/autoload.php";

class ForgettenPasswordEmailCommand implements Command {
    private UserController $userController;
    function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    function process($params = []){
        return $this->userController->sendChangeForgettenPasswordEmail();
    }

}