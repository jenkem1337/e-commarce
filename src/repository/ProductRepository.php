<?php
interface ProductRepository {
    function createCategory(ProductForCreatingCategoryDecorator $c, $categoryUuidForFinding);
    function findAllCategory():ProductInterface;
    function findOneCategoryByUuid($uuid):ProductInterface;
    function updateCategoryNameByUuid(ProductInterface $c, $categoryUuidForFinding);
    function findOneCategoryByName($categoryName):ProductInterface;
    function deleteCategoryByUuid($uuid);
}