<?php
interface CategoryDao extends SaveChangesInterface, DatabaseTransaction{
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