<?php

class ShippingControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params): ShippingController
    {
        return new ShippingController(
            new TransactionalShippingServiceDecorator(
                new ShippingServiceImpl(
                    new ShippingRepositoryImpl(
                        new ShippingDaoImpl(MySqlPDOConnection::getInstance()),
                        new ShippingFactoryContext(
                            [
                                ShippingType::SAME_DAY => new ConcreteSameDayShippingFactory,
                                ShippingType::TWO_DAY => new ConcreteTwoDayShippingFactory,
                                ShippingType::LONG_DISTANCE => new ConcreteLongDistanceFactory
                            ]
                        )
                    )
                ), 
                MySqlPDOConnection::getInstance()
            )
        );
    }
}