<?php
interface ProductRepository {
    //product
    function createProduct(Product $p);
    function findOneProductByUuid($uuid):ProductInterface;
    function updateProductBrandName(Product $p);
    function updateProductModelName(Product $p);

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