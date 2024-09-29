<?php

class ImageControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params):ImageController
    {
        $productRepositoryImpl = new ProductRepositoryImpl(
            new ProductDaoImpl(MySqlPDOConnection::getInstance())
        );
        
        $imageRepositoryImpl = new ImageRepositoryImpl(
            new ImageDaoImpl(MySqlPDOConnection::getInstance()),
            new ConcreteImageFactory()
        );
        $imageRepositoryImpl->setProductMediator($productRepositoryImpl);

        $productRepositoryAggregateRootDecorator = new ProductRepositoryAggregateRootDecorator($productRepositoryImpl);

        return new ImageController(
            new TransactionalImageServiceDecorator(
                new ImageServiceImpl(
                    $productRepositoryAggregateRootDecorator,
                    new UploadServiceImpl(),
                    new ConcreteImageFactory
                ),
                MySqlPDOConnection::getInstance()
            )
        );

    }
}