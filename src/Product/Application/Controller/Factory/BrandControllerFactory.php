<?php 

class BrandControllerFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params){
        $brandDao = new BrandDaoImpl(MySqlPDOConnection::getInstance());
        $modelDao = new ModelDaoImpl(MySqlPDOConnection::getInstance());

        $modelRepository = new ModelRepositoryImpl($modelDao);
        $brandRepository = new BrandRepositoryImpl($brandDao, $modelRepository);

        $brandService = new BrandServiceImpl($brandRepository);
        $transactionalBrandService = new TransactionalBrandService($brandService, $brandRepository);

        return new BrandController($transactionalBrandService);
    }
}