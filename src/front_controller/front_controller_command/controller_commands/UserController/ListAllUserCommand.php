<?php
require "./vendor/autoload.php";
class ListAllUserCommand implements Command{
    private UserController $userController;
    private Middleware $firstMiddleware;
    function __construct(Middleware $firstMiddleware,UserController $userController)
    {
        $this->firstMiddleware = $firstMiddleware;
        $this->userController = $userController;
    }

    function process($params = []){
        $this->firstMiddleware
                        ->linkWith(new IsAdminMiddleware());
        
        $this->firstMiddleware->check();
        return $this->userController->listAllUser();
    }

}