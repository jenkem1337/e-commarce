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
    function persistProductSubscriber(AggregateRoot $p)
    {
        parent::persistProductSubscriber($p);
    }
    function updateProductStockQuantity(AggregateRoot $p)
    {
        parent::updateProductStockQuantity($p);
    }
    function deleteProductByUuid(AggregateRoot $p)
    {
        parent::deleteProductByUuid($p);
    }
    function updateProductBrandName(AggregateRoot $p)
    {
        parent::updateProductBrandName($p);
    }
    function createProductCategory(AggregateRoot $c, $categoryUuidForFinding)
    {
        parent::createProductCategory($c, $categoryUuidForFinding);
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
    function updateProductCategoryNameByUuid(AggregateRoot $c, $categoryUuidForFinding)
    {
        parent::updateProductCategoryNameByUuid($c, $categoryUuidForFinding);
    }
}