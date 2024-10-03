<?php

class ShippingControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params): ShippingController
    {
        $repo = new ShippingRepositoryImpl(new ShippingDaoImpl(MySqlPDOConnection::getInstance()));

        return new ShippingController(
            new TransactionalShippingServiceDecorator(
                new ShippingServiceImpl($repo), 
                $repo
            )
        );
    }
}