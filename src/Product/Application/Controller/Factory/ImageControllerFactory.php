<?php

class ImageControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params):ImageController
    {
        
        
        $imageRepositoryImpl = new ImageRepositoryImpl(
            new ImageDaoImpl(MySqlPDOConnection::getInstance()),
        );
        
        $productRepositoryImpl = ProductRepositoryImpl::newInstaceWithOnlyImageRepository(
            new ProductDaoImpl(MySqlPDOConnection::getInstance()),
            $imageRepositoryImpl);
        
            $productRepositoryAggregateRootDecorator = new ProductRepositoryAggregateRootDecorator($productRepositoryImpl);

        return new ImageController(
            new TransactionalImageServiceDecorator(
                new ImageServiceImpl(
                    $productRepositoryAggregateRootDecorator,
                    new UploadServiceImpl(MinIOConnection::getInstance()),
                ),
                $productRepositoryImpl
            )
        );

    }
}