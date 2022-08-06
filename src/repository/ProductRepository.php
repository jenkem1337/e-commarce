<?php
interface ProductRepository {
    function createProduct(Product $p);
    function findOneProductByUuid($uuid):ProductInterface;
    function persistImage(Product $p);
    function createCategory(ProductForCreatingCategoryDecorator $c, $categoryUuidForFinding);
    function findAllCategory():ProductInterface;
    function findOneCategoryByUuid($uuid):ProductInterface;
    function updateCategoryNameByUuid(Product $c, $categoryUuidForFinding);
    function findOneCategoryByName($categoryName):ProductInterface;
    function deleteCategoryByUuid($uuid);
}