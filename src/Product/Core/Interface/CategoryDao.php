<?php
interface CategoryDao {
    function saveChanges(Category $category);
    function persist(Category $c);
    function deleteByUuid($uuid);
    function findByUuid($uuid);
    function updateNameByUuid(Category $c);
    function findAll();
    function findOneByName($categoryName);
    function addCategoryUuidToProduct(Category $c);
    function findAllByProductUuid($uuid);
    function deleteCategoryByProductUuid($uuid);

    function findASetOfByUuids($uuids);
}