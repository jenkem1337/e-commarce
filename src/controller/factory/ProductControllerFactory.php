<?php

use PHPMailer\PHPMailer\PHPMailer;


class ProductControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params):ProductController
    {

        $productRepositoryImpl = new ProductRepositoryImpl(
            new ProductFactoryContext([
                ProductFactory::class => new ConcreteProductFactory(),
                ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
            ]),
            new ConcreteProductSubscriberFactory,
            new ProductDaoImpl(MySqlPDOConnection::getInsatace())
        );
        
        
        $categoryRepositoryImpl = new CategoryRepositoryImpl(
            new CategoryDaoImpl(MySqlPDOConnection::getInsatace()),
            new  ConcreteCategoryFactory()
        );
        $rateRepositoryImpl = new RateRepositoryImpl(
            new RateDaoImpl(MySqlPDOConnection::getInsatace()),
            new ConcreteRateFactory()
        );
        $commentRepositoryImpl = new CommentRepositoryImpl(
            new CommentDaoImpl(MySqlPDOConnection::getInsatace()),
            new ConcreteCommentFactory()
        );
        $imageRepositoryImpl = new ImageRepositoryImpl(
            new ImageDaoImpl(MySqlPDOConnection::getInsatace()),
            new ConcreteImageFactory()
        );
        $commentRepositoryImpl->setProductMediator($productRepositoryImpl);
        $rateRepositoryImpl->setProductMediator($productRepositoryImpl);
        $imageRepositoryImpl->setProductMediator($productRepositoryImpl);
        $categoryRepositoryImpl->setProductMediator($productRepositoryImpl);


        return new ProductController(
            new TransactionalProductServiceDecorator(
                new ProductServiceImpl(
                    $productRepositoryImpl,
                    new ShippingRepositoryImpl(
                        new ShippingDaoImpl(MySqlPDOConnection::getInsatace()),
                        new ShippingFactoryContext(
                            [
                                ShippingType::SAME_DAY => new ConcreteSameDayShippingFactory,
                                ShippingType::TWO_DAY => new ConcreteTwoDayShippingFactory,
                                ShippingType::LONG_DISTANCE => new ConcreteLongDistanceFactory
                            ]
                        )
                    ),
                    new UploadServiceImpl,
                    new EmailServiceImpl(new PHPMailer(true)),
                    new ProductFactoryContext([
                        ProductFactory::class => new ConcreteProductFactory(),
                        ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
                    ]),
                    new ConcreteProductSubscriberFactory
                ), MySqlPDOConnection::getInsatace()
            )
        );
    }
}