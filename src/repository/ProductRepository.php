<?php
interface ProductRepository {
    //product
    function createProduct(Product $p);
    function persistProductSubscriber(Product $p);
    function findOneProductByUuid($uuid):ProductInterface;
    function updateProductBrandName(Product $p);
    function updateProductModelName(Product $p);
    function updateProductHeader(Product $p);
    function updateProductDescription(Product $p);
    function updateProductPrice(Product $p);
    function updateProductStockQuantity(Product $p);
    function findAllProducts(): IteratorAggregate;
    function findProductsByPriceRange($from, $to): IteratorAggregate;
    function findProductsBySearch($searchValue, $startingLimit, $perPageForProduct): IteratorAggregate;
    function findAllWithPagination($startingLimit, $perPageForProduct): IteratorAggregate;
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
    function deleteProductCategoryByUuid($uuid);
}