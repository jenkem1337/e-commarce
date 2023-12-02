<?php
use PHPMailer\PHPMailer\PHPMailer;
use Predis\Client;
require './vendor/autoload.php';
class ProductServiceFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params): ProductService
    {
        $productRepositoryImpl = new ProductRepositoryImpl(
            new ProductFactoryContext([
                ProductFactory::class => new ConcreteProductFactory(),
                ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
            ]),
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
    
    
       return new TransactionalProductServiceDecorator(
                new ProductServiceImpl(
                    $productRepositoryImpl,
                    new UploadServiceImpl,
                    new EmailServiceImpl(new PHPMailer(true)),
                    new ProductFactoryContext([
                        ProductFactory::class => new ConcreteProductFactory(),
                        ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
                    ]),
                    new ConcreteProductSubscriberFactory,
                    new Client('tcp://127.0.0.1:6379'."?read_write_timeout=0")
                ), MySqlPDOConnection::getInstance()
            );
    
    }
}