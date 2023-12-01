<?php

class CategoryControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params): CategoryController
    {
        $productRepositoryImpl = new ProductRepositoryImpl(
            new ProductFactoryContext([
                ProductFactory::class => new ConcreteProductFactory(),
                ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
            ]),
            new ConcreteProductSubscriberFactory,
            new ProductDaoImpl(MySqlPDOConnection::getInstance())
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
        
        $productRepositoryAggregateRootDecorator = new ProductRepositoryAggregateRootDecorator($productRepositoryImpl);
        
        $categoryRepositoryImpl->setProductMediator($productRepositoryImpl);
        return new CategoryController(
                    new TransactionalCategoryServiceDecorator(
                        new CategoryServiceImpl(
                            $productRepositoryAggregateRootDecorator,
                            new ConcreteCategoryFactory,
                            new ProductFactoryContext([
                                ProductFactory::class => new ConcreteProductFactory(),
                                ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
                            ])
                        ),MySqlPDOConnection::getInstance()
                    )
                );
        
    }
}