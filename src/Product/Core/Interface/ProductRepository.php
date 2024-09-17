<?php
interface ProductRepository {
    //product
    function saveChanges($e);
    function createProduct(Product $p);
    function persistProductSubscriber(Product $p);
    function findOneProductByUuid($uuid, $filter): ProductInterface;
   
    function findAllProducts($filter): IteratorAggregate;
    function findProductsByPriceRange($from, $to, $filter): IteratorAggregate;
    function findProductsBySearch($searchValue, $startingLimit, $perPageForProduct, $filter): IteratorAggregate;
    function findAllWithPagination($startingLimit, $perPageForProduct, $filter): IteratorAggregate;
    function deleteProductByUuid(Product $product);
    function deleteProductSubscriberByUserAndProductUuid($userUuid, $productUuid);

    //image
    function persistImage(Product $p);
    function deleteImageByUuid($uuid);

    //category
    function createProductCategory(ProductForCreatingCategoryDecorator $c, $categoryUuidForFinding);
    function findAllProductCategory():ProductInterface;
    function findOneProductCategoryByUuid($uuid):ProductInterface;
    function updateProductCategoryNameByUuid(Product $c, $categoryUuidForFinding);
    function findOneProductCategoryByName($categoryName):ProductInterface;
    function findASetOfProductCategoryByUuids($uuids):ProductInterface;
    function deleteProductCategoryByUuid($uuid);
    function findOneProductWithOnlySubscriberByUuid($uuid, $userUuid): ProductInterface;
}