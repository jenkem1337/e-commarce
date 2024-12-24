<?php
use PHPMailer\PHPMailer\PHPMailer;
class UserControllerFactory implements Factory {
    
    function createInstance($isMustBeConcreteObject = false,...$params):UserController {
        $userRepository = new UserRepositoryImpl(
            new UserDaoImpl(MySqlPDOConnection::getInstance()),
            new RefreshTokenDaoImpl(new RedisConnection()),
        );
        $userAggregateRepositoryDecorator = new UserRepositoryAggregateRootDecorator($userRepository);

        return new UserController(
            new TransactionalUserServiceDecorator(
                new UserServiceImpl($userAggregateRepositoryDecorator), 
                $userRepository

            ),new TransactionalAuthServiceDecorator(
                new AuthServiceImpl(
                    $userAggregateRepositoryDecorator,
                    KafkaConnection::getInstance(),
                ), $userRepository
            )
        );
    }
}