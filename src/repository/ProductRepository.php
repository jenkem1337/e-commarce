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
    function createCategory(ProductForCreatingCategoryDecorator $c, $categoryUuidForFinding);
    function findAllCategory():ProductInterface;
    function findOneCategoryByUuid($uuid):ProductInterface;
    function updateCategoryNameByUuid(Product $c, $categoryUuidForFinding);
    function findOneCategoryByName($categoryName):ProductInterface;
    function deleteCategoryByUuid($uuid);
}