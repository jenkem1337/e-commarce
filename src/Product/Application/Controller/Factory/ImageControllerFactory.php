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
        

        return new ImageController(
            new TransactionalImageServiceDecorator(
                new ImageServiceImpl(
                    $productRepositoryImpl,
                    new UploadServiceImpl(MinIOConnection::getInstance()),
                ),
                $productRepositoryImpl
            )
        );

    }
}