<?php

class CategoryControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params): CategoryController
    {
        $categoryRepositoryImpl = new CategoryRepositoryImpl(
            new CategoryDaoImpl(MySqlPDOConnection::getInstance()),
        );
        
        return new CategoryController(
                    new TransactionalCategoryServiceDecorator(
                        new CategoryServiceImpl(
                            $categoryRepositoryImpl,
                        ),MySqlPDOConnection::getInstance()
                    )
                );
        
    }
}