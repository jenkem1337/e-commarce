<?php
interface CategoryDao {
    function persist(Category $c);
    function deleteByUuid($uuid);
    function findByUuid($uuid);
    function updateNameByUuid(Category $c);
    function findAll();
    function findOneByName($categoryName);
    function addCategoryUuidToProduct($productUuid);
}