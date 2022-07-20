<?php

require "./vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
class UserControllerFactory implements Factory {
    
    function createInstance($isMustBeConcreteObject = false,...$params):UserController {
        return new UserController(
            new UserServiceImpl(
                new UserRepositoryAggregateRootDecorator(
                    new UserRepositoryImpl(
                        new UserDaoImpl(MySqlPDOConnection::getInsatace()),
                        new RefreshTokenDaoImpl(new RedisConnection()),
                        new ConcreteUserFactory(),
                        new ConcreteRefreshTokenFactory()        
                    )
                )
            ),new AuthServiceImpl(
                new UserRepositoryAggregateRootDecorator(
                    new UserRepositoryImpl(
                        new UserDaoImpl(MySqlPDOConnection::getInsatace()),
                        new RefreshTokenDaoImpl(new RedisConnection()),
                        new ConcreteUserFactory(),
                        new ConcreteRefreshTokenFactory()
        
                    )
                ),
                new EmailServiceImpl(new PHPMailer(true)),
                new ConcreteUserFactory(),
                new ConcreteRefreshTokenFactory()
                )
        );
    }
}