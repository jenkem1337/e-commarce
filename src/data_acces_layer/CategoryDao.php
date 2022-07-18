<?php
interface CategoryDao {
    function persist(Category $c);
    function deleteByUuid(Category $c);
    function findByUuid(Category $c);
    function updateByUuid(Category $c);
    function findAll();
    function addCategoryUuidToProduct($productUuid);
}