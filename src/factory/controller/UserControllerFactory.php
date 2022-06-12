<?php

use UserController as GlobalUserController;

require "./vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
class UserControllerFactory implements Factory {
    
    function createInstance(...$params):UserController {
        return new UserController(new UserServiceImpl(new UserRepositoryImpl(new UserDaoImpl(new MySqlPDOConnection()),new RefreshTokenDaoImpl(new RedisConnection()))), new AuthServiceImpl(new UserRepositoryImpl(new UserDaoImpl(new MySqlPDOConnection()), new RefreshTokenDaoImpl(new RedisConnection())), new EmailServiceImpl(new PHPMailer(true))));
    }
}