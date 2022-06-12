<?php
require "./vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
class AuthControllerFactory implements Factory{
    function createInstance(...$params):AuthController {
        return new AuthController(new AuthServiceImpl(new UserRepositoryImpl(new UserDaoImpl(new MySqlPDOConnection()), new RefreshTokenDaoImpl(new RedisConnection())), new EmailServiceImpl(new PHPMailer(true))));
    }
}