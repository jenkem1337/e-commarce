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
        

        $productRepositoryAggregateRootDecorator = new ProductRepositoryAggregateRootDecorator($productRepositoryImpl);

        return new ProductController(
            new TransactionalProductServiceDecorator(
                new ProductServiceImpl(
                    $productRepositoryAggregateRootDecorator,
                    $categoryRepositoryImpl,
                    new UploadServiceImpl(MinIOConnection::getInstance()),
                    new EmailServiceImpl(new PHPMailer(true)),
                ), $productRepositoryImpl
            )
        );
    }
}