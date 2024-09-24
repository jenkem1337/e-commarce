<?php
interface ProductRepository {
    //product
    function saveChanges($e);
    function createProduct(Product $p);
    function findOneProductByUuid($uuid, $filter): ProductInterface;
   
    function findProductsByCriteria(FindProductsByCriteriaDto $findProductsByCriteriaDto): IteratorAggregate;
    function findProductsBySearch($searchValue, $startingLimit, $perPageForProduct, $filter): IteratorAggregate;
    function deleteProductByUuid(Product $product);

    //image
    function persistImage(Product $p);
    function deleteImageByUuid($uuid);

    //category
    function createProductCategory(ProductForCreatingCategoryDecorator $c, $categoryUuidForFinding);
    function findAllProductCategory():mixed;
    function findOneProductCategoryByUuid($uuid):ProductInterface;
    function updateProductCategoryNameByUuid(Product $c, $categoryUuidForFinding);
    function findOneProductCategoryByName($categoryName):ProductInterface;
    function findASetOfProductCategoryByUuids($uuids):ProductInterface;
    function deleteProductCategoryByUuid($uuid);
    function findOneProductWithOnlySubscriberByUuid($uuid, $userUuid): ProductInterface;
}