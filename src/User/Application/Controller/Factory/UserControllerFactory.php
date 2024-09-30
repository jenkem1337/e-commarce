<?php
use PHPMailer\PHPMailer\PHPMailer;
class UserControllerFactory implements Factory {
    
    function createInstance($isMustBeConcreteObject = false,...$params):UserController {
        return new UserController(
            new TransactionalUserServiceDecorator(
                new UserServiceImpl(
                    new UserRepositoryAggregateRootDecorator(
                        new UserRepositoryImpl(
                            new UserDaoImpl(MySqlPDOConnection::getInstance()),
                            new RefreshTokenDaoImpl(new RedisConnection()),
                        )
                    )
                ), MySqlPDOConnection::getInstance() 

            ),new TransactionalAuthServiceDecorator(
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