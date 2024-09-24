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
    function findProductsByCriteria($filter): IteratorAggregate
    {
        return $this->productRepository->findProductsByCriteria($filter);
    }
    function deleteProductByUuid(Product $p)
    {
        $this->productRepository->deleteProductByUuid($p);   
    }
    function findProductsBySearch($searchValue, $startingLimit, $perPageForProduct, $filter): IteratorAggregate
    {
        return $this->productRepository->findProductsBySearch($searchValue, $startingLimit, $perPageForProduct, $filter);
    }
    function findOneProductByUuid($uuid, $filter):ProductInterface
    {
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
    function createProductCategory(ProductForCreatingCategoryDecorator $c, $categoryUuidForFinding)
    {

            $this->productRepository->createProductCategory($c, $categoryUuidForFinding);


    }
    function findAllProductCategory(): ProductInterface
    {
        return $this->productRepository->findAllProductCategory();
    }
    function findOneProductCategoryByName($categoryName): ProductInterface
    {
        return $this->productRepository->findOneProductCategoryByName($categoryName);
    }
    function findOneProductCategoryByUuid($uuid): ProductInterface
    {
        return $this->productRepository->findOneProductCategoryByUuid($uuid);
    }
    function updateProductCategoryNameByUuid(Product $c, $categoryUuidForFinding)
    {
        $this->productRepository->updateProductCategoryNameByUuid($c, $categoryUuidForFinding);
    }
    function deleteProductCategoryByUuid($uuid)
    {
        $this->productRepository->deleteProductCategoryByUuid($uuid);
    }

    function findASetOfProductCategoryByUuids($uuids):ProductInterface {
        return $this->productRepository->findASetOfProductCategoryByUuids($uuids);
    }

    function findOneProductWithOnlySubscriberByUuid($uuid, $userUuid): ProductInterface{
        return $this->productRepository->findOneProductWithOnlySubscriberByUuid($uuid, $userUuid);
    }
 
}