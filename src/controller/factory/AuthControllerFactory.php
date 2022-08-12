<?php
use PHPMailer\PHPMailer\PHPMailer;
class AuthControllerFactory implements Factory{
    function createInstance($isMustBeConcreteObject = false, ...$params):AuthController {
        return new AuthController(
            new TransactionalAuthServiceDecorator(
                new AuthServiceImpl(
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
    
                ), MySqlPDOConnection::getInsatace()
            )
        );
    }
}