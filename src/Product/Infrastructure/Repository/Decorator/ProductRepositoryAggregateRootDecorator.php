<?php



class ProductRepositoryAggregateRootDecorator extends ProductRepositoryDecorator {
    function __construct(ProductRepository $repo)
    {
        parent::__construct($repo);
    }
    function saveChanges($e){
        parent::saveChanges($e);
    }
    function persistImage(AggregateRoot $p)
    {
        parent::persistImage($p);
    }
    
    function createProduct(AggregateRoot $p)
    {
        parent::createProduct($p);
    }
    function deleteProductByUuid(AggregateRoot $p)
    {
        parent::deleteProductByUuid($p);
    }
    function createProductCategory(AggregateRoot $c, $categoryUuidForFinding)
    {
        parent::createProductCategory($c, $categoryUuidForFinding);
    }
    function updateProductCategoryNameByUuid(AggregateRoot $c, $categoryUuidForFinding)
    {
        parent::updateProductCategoryNameByUuid($c, $categoryUuidForFinding);
    }

}