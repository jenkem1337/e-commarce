<?php

use PHPMailer\PHPMailer\PHPMailer;
use Predis\Client;

class ProductControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params):ProductController
    {

        
        $productSubscriberRepoImpl = new ProductSubscriberRepositoryImpl(
            new ProductDaoImpl(MySqlPDOConnection::getInstance()),
        );
        $categoryRepositoryImpl = new CategoryRepositoryImpl(
            new CategoryDaoImpl(MySqlPDOConnection::getInstance()),
        );
        $rateRepositoryImpl = new RateRepositoryImpl(
            new RateDaoImpl(MySqlPDOConnection::getInstance()),
        );
        $commentRepositoryImpl = new CommentRepositoryImpl(
            new CommentDaoImpl(MySqlPDOConnection::getInstance()),
        );
        $imageRepositoryImpl = new ImageRepositoryImpl(
            new ImageDaoImpl(MySqlPDOConnection::getInstance()),
        );
        $productRepositoryImpl = new ProductRepositoryImpl(
                new ProductDaoImpl(MySqlPDOConnection::getInstance()),
                $productSubscriberRepoImpl,
                $commentRepositoryImpl,
                $rateRepositoryImpl,
                $imageRepositoryImpl
        );
        $brandRepository = new BrandRepositoryImpl(
            new BrandDaoImpl(MySqlPDOConnection::getInstance()),
            new ModelRepositoryImpl(new ModelDaoImpl(MySqlPDOConnection::getInstance()))
        );

        $productRepositoryAggregateRootDecorator = new ProductRepositoryAggregateRootDecorator($productRepositoryImpl);
        $orderService = new OrderServiceImpl(new OrderRepositoryImpl(new OrderDaoImpl(MySqlPDOConnection::getInstance())),null,null,null,null);
        return new ProductController(
            new TransactionalProductServiceDecorator(
                new ProductServiceImpl(
                    $productRepositoryAggregateRootDecorator,
                    $categoryRepositoryImpl,
                    $brandRepository,
                    new UploadServiceImpl(MinIOConnection::getInstance()),
                    new EmailServiceImpl(new PHPMailer(true)),
                    $orderService
                ), $productRepositoryImpl
            )
        );
    }
}