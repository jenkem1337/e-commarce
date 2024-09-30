<?php

use PHPMailer\PHPMailer\PHPMailer;
use Predis\Client;

class ProductControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params):ProductController
    {

        $productRepositoryImpl = new ProductRepositoryImpl(
            new ProductDaoImpl(MySqlPDOConnection::getInstance())
        );
        
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
        $commentRepositoryImpl->setProductMediator($productRepositoryImpl);
        $rateRepositoryImpl->setProductMediator($productRepositoryImpl);
        $imageRepositoryImpl->setProductMediator($productRepositoryImpl);
        $productSubscriberRepoImpl->setProductMediator($productRepositoryImpl);

        $productRepositoryAggregateRootDecorator = new ProductRepositoryAggregateRootDecorator($productRepositoryImpl);

        return new ProductController(
            new TransactionalProductServiceDecorator(
                new ProductServiceImpl(
                    $productRepositoryAggregateRootDecorator,
                    $categoryRepositoryImpl,
                    new UploadServiceImpl,
                    new EmailServiceImpl(new PHPMailer(true)),
                ), MySqlPDOConnection::getInstance()
            )
        );
    }
}