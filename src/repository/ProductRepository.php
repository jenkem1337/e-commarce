<?php
interface ProductRepository {
    function createCategory(ProductForCreatingCategoryDecorator $c);
    function findAllCategory():ProductInterface;
    function findOneCategoryByUuid($uuid):ProductInterface;
    function updateCategoryNameByUuid(ProductInterface $c);
}