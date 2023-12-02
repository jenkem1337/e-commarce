<?php

class ImageControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params):ImageController
    {
        $productRepositoryImpl = new ProductRepositoryImpl(
            new ProductFactoryContext([
                ProductFactory::class => new ConcreteProductFactory(),
                ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
            ]),
            new ProductDaoImpl(MySqlPDOConnection::getInstance())
        );
        
        
        $productSubscriberRepoImpl = new ProductSubscriberRepositoryImpl(
            new ProductDaoImpl(MySqlPDOConnection::getInstance()),
            new ConcreteProductSubscriberFactory(),
        );
        $categoryRepositoryImpl = new CategoryRepositoryImpl(
            new CategoryDaoImpl(MySqlPDOConnection::getInstance()),
            new  ConcreteCategoryFactory()
        );
        $rateRepositoryImpl = new RateRepositoryImpl(
            new RateDaoImpl(MySqlPDOConnection::getInstance()),
            new ConcreteRateFactory()
        );
        $commentRepositoryImpl = new CommentRepositoryImpl(
            new CommentDaoImpl(MySqlPDOConnection::getInstance()),
            new ConcreteCommentFactory()
        );
        $imageRepositoryImpl = new ImageRepositoryImpl(
            new ImageDaoImpl(MySqlPDOConnection::getInstance()),
            new ConcreteImageFactory()
        );
        $commentRepositoryImpl->setProductMediator($productRepositoryImpl);
        $rateRepositoryImpl->setProductMediator($productRepositoryImpl);
        $imageRepositoryImpl->setProductMediator($productRepositoryImpl);
        $categoryRepositoryImpl->setProductMediator($productRepositoryImpl);
        $productSubscriberRepoImpl->setProductMediator($productRepositoryImpl);

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