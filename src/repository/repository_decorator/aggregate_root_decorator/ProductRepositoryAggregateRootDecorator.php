<?php



class ProductRepositoryAggregateRootDecorator extends ProductRepositoryDecorator {
    function __construct(ProductRepository $repo)
    {
        parent::__construct($repo);
    }
    function persistImage(AggregateRoot $p)
    {
        parent::persistImage($p);
    }
    function updateProductModelName(AggregateRoot $p)
    {
        parent::updateProductModelName($p);
    }
    function createProduct(AggregateRoot $p)
    {
        parent::createProduct($p);
    }
    function updateProductBrandName(AggregateRoot $p)
    {
        parent::updateProductBrandName($p);
    }
    function createCategory(AggregateRoot $c, $categoryUuidForFinding)
    {
        parent::createCategory($c, $categoryUuidForFinding);
    }
    function updateProductHeader(AggregateRoot $p)
    {
        parent::updateProductHeader($p);
    }
    function updateProductPrice(AggregateRoot $p)
    {
        parent::updateProductPrice($p);
    }
    function updateProductDescription(AggregateRoot $p)
    {
        parent::updateProductDescription($p);
    }
    function updateCategoryNameByUuid(AggregateRoot $c, $categoryUuidForFinding)
    {
        parent::updateCategoryNameByUuid($c, $categoryUuidForFinding);
    }
}