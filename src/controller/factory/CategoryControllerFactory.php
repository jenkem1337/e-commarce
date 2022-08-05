<?php
require './vendor/autoload.php';

class CategoryControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params): CategoryController
    {
        $productRepositoryImpl =new ProductRepositoryImpl(new ProductFactoryContext([
            ProductFactory::class => new ConcreteProductFactory(),
            ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
        ]));
        $categoryRepositoryImpl = new CategoryRepositoryImpl(
            new CategoryDaoImpl(MySqlPDOConnection::getInsatace()),
            new  ConcreteCategoryFactory()
        );
        $categoryRepositoryImpl->setProductMediator($productRepositoryImpl);
        return new CategoryController(
                new TransactionalProductServiceDecorator(
                    new ProductServiceImpl(
                        $productRepositoryImpl,
                    new ProductFactoryContext([
                        ProductFactory::class => new ConcreteProductFactory(),
                        ProductCategoryCreationalModelFactory::class => new ConcreteProductCategoryCreationalModelFactory()
                    ]),
                    new  ConcreteCategoryFactory()
                    ), MySqlPDOConnection::getInsatace()
                )
            );
    }
}