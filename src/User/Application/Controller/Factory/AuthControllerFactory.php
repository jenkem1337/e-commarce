<?php
class AuthControllerFactory implements Factory{
    function createInstance($isMustBeConcreteObject = false, ...$params):AuthController {
        $userRepository = new UserRepositoryImpl(
            new UserDaoImpl(MySqlPDOConnection::getInstance()), 
            new RefreshTokenDaoImpl(new RedisConnection()),
        );

        return new AuthController(
            new TransactionalAuthServiceDecorator(
                new AuthServiceImpl(
                    new UserRepositoryAggregateRootDecorator(
                        $userRepository
                    ),
                    KafkaConnection::getInstance()
    
                ), $userRepository
            )
        );
    }
}