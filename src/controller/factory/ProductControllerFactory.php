<?php
require './vendor/autoload.php';

class ProductControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params):ProductController
    {
        $productRepositoryImpl = new ProductRepositoryImpl(
            new ProductFactoryContext([
                ProductFactory::class => new ConcreteProductFactory(),
                ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
            ]),
            new ProductDaoImpl(MySqlPDOConnection::getInsatace())
        );
        
        
        $categoryRepositoryImpl = new CategoryRepositoryImpl(
            new CategoryDaoImpl(MySqlPDOConnection::getInsatace()),
            new  ConcreteCategoryFactory()
        );
        
        $imageRepositoryImpl = new ImageRepositoryImpl(
            new ImageDaoImpl(MySqlPDOConnection::getInsatace()),
            new ConcreteImageFactory()
        );
        $imageRepositoryImpl->setProductMediator($productRepositoryImpl);
        $categoryRepositoryImpl->setProductMediator($productRepositoryImpl);

        return new ProductController(
            new TransactionalProductServiceDecorator(
                new ProductServiceImpl(
                    $productRepositoryImpl,
                    new ProductFactoryContext([
                        ProductFactory::class => new ConcreteProductFactory(),
                        ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
                    ]),
                    new ConcreteCategoryFactory(),
                    new ConcreteImageFactory(),
                    new UploadServiceImpl()
                ), MySqlPDOConnection::getInsatace()
            )
        );
    }
}