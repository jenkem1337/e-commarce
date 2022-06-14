<?php

require "./vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
class UserControllerFactory implements Factory {
    
    function createInstance(...$params):UserController {
        return new UserController(
            new UserServiceImpl(
                new UserRepositoryAggregateRootDecorator(
                    new UserRepositoryImpl(
                        new UserDaoImpl(new MySqlPDOConnection()),
                        new RefreshTokenDaoImpl(new RedisConnection())
                    )
                )
            ),new AuthServiceImpl(
                new UserRepositoryAggregateRootDecorator(
                    new UserRepositoryImpl(
                        new UserDaoImpl(new MySqlPDOConnection()),
                        new RefreshTokenDaoImpl(new RedisConnection())

                    )
                ),
                new EmailServiceImpl(new PHPMailer(true)))
        );
    }
}