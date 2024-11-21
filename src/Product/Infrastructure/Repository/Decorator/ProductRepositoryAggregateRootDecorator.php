<?php



class ProductRepositoryAggregateRootDecorator extends ProductRepositoryDecorator {
    function __construct(ProductRepository $repo)
    {
        parent::__construct($repo);
    }
    function saveChanges($e){
        parent::saveChanges($e);
    }
    function deleteProductByUuid(AggregateRoot $p)
    {
        parent::deleteProductByUuid($p);
    }

}