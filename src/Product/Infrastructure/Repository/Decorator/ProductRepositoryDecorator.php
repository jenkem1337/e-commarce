<?php

abstract class ProductRepositoryDecorator implements ProductRepository {
    private ProductRepository $productRepository;
    function __construct(ProductRepository $r)
    {
        $this->productRepository = $r;
    }
    function saveChanges($e){
        $this->productRepository->saveChanges($e);
    }
    function createProduct(Product $p)
    {
        $this->productRepository->createProduct($p);
    }
    function findProductsByCriteria($filter)
    {
        return $this->productRepository->findProductsByCriteria($filter);
    }
    function deleteProductByUuid(Product $p)
    {
        $this->productRepository->deleteProductByUuid($p);   
    }
    function findProductsBySearch($searchValue, $startingLimit, $perPageForProduct, $filter)
    {
        return $this->productRepository->findProductsBySearch($searchValue, $startingLimit, $perPageForProduct, $filter);
    }
    function findOneProductAggregateByUuid($uuid, $filter):ProductInterface
    {
        return $this->productRepository->findOneProductAggregateByUuid($uuid, $filter);
    }
    function findOneProductByUuid($uuid, $filter) {
        return $this->productRepository->findOneProductByUuid($uuid, $filter);

    }
    function persistImage(Product $p)
    {
        $this->productRepository->persistImage($p);
    }
    function deleteImageByUuid($uuid)
    {
        $this->productRepository->deleteImageByUuid($uuid);
    }
    function findOneProductWithOnlySubscriberByUuid($uuid, $userUuid): ProductInterface{
        return $this->productRepository->findOneProductWithOnlySubscriberByUuid($uuid, $userUuid);
    }
 
}