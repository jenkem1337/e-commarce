<?php
interface ProductRepository {
    //product
    function saveChanges($e);
    function createProduct(Product $p);
    function findOneProductByUuid($uuid, $filter);
    function findOneProductAggregateByUuid($uuid, $filter): ProductInterface;
    
    function findProductsByCriteria(FindProductsByCriteriaDto $findProductsByCriteriaDto);
    function findProductsBySearch($searchValue, $startingLimit, $perPageForProduct, $filter);
    function deleteProductByUuid(Product $product);

    //image
    function persistImage(Product $p);
    function deleteImageByUuid($uuid);

    function findOneProductWithOnlySubscriberByUuid($uuid, $userUuid): ProductInterface;
}