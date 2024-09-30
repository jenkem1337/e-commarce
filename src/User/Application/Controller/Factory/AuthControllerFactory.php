<?php
use PHPMailer\PHPMailer\PHPMailer;
class AuthControllerFactory implements Factory{
    function createInstance($isMustBeConcreteObject = false, ...$params):AuthController {
        return new AuthController(
            new TransactionalAuthServiceDecorator(
                new AuthServiceImpl(
                    new UserRepositoryAggregateRootDecorator(
                        new UserRepositoryImpl(
                            new UserDaoImpl(MySqlPDOConnection::getInstance()), 
                            new RefreshTokenDaoImpl(new RedisConnection()),
                        )
                    ),
                    new EmailServiceImpl(new PHPMailer(true)),
    
                ), MySqlPDOConnection::getInstance()
            )
        );
    }
}