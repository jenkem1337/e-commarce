<?php

use Predis\Configuration\Option\Aggregate;

require './vendor/autoload.php';

class ProductRepositoryAggregateRootDecorator extends ProductRepositoryDecorator {
    function __construct(ProductRepository $repo)
    {
        parent::__construct($repo);
    }
    function persistImage(AggregateRoot $p)
    {
        parent::persistImage($p);
    }
    function createProduct(AggregateRoot $p)
    {
        parent::createProduct($p);
    }
    function createCategory(AggregateRoot $c, $categoryUuidForFinding)
    {
        parent::createCategory($c, $categoryUuidForFinding);
    }
    function updateCategoryNameByUuid(AggregateRoot $c, $categoryUuidForFinding)
    {
        parent::updateCategoryNameByUuid($c, $categoryUuidForFinding);
    }
}