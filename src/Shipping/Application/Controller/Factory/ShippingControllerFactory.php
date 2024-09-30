<?php

class ShippingControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params): ShippingController
    {
        return new ShippingController(
            new TransactionalShippingServiceDecorator(
                new ShippingServiceImpl(
                    new ShippingRepositoryImpl(
                        new ShippingDaoImpl(MySqlPDOConnection::getInstance()),
                    )
                ), 
                MySqlPDOConnection::getInstance()
            )
        );
    }
}