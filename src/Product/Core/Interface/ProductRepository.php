<?php
interface ProductRepository {
    //product
    function saveChanges($e);
    function findOneProductByUuid($uuid, $filter);
    function findOneProductAggregateByUuid($uuid, $filter): ProductInterface;
    
    function findProductsByCriteria(FindProductsByCriteriaDto $findProductsByCriteriaDto);
    function findProductsBySearch($searchValue, $startingLimit, $perPageForProduct, $filter);
    function deleteProductByUuid(Product $product);

    function findOneProductWithOnlySubscriberByUuid($uuid, $userUuid): ProductInterface;
    function findManyAggregateByUuids($uuids):ProductCollection;
}