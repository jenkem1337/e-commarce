<?php
interface CategoryDao {
    function persist(Category $c);
    function deleteByUuid($uuid);
    function findByUuid($uuid);
    function updateNameByUuid($uuid, $categoryName);
    function findAll();
    function addCategoryUuidToProduct($productUuid);
}