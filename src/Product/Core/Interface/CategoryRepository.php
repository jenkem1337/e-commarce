<?php

interface CategoryRepository {
    function persist(CategoryInterface $c);
    function deleteByUuid($uuid);
    function findByUuid($uuid):CategoryInterface;
    function findAllByProductUuid($productUuid):IteratorAggregate;
    function updateNameByUuid(CategoryInterface $c);
    function findAll():mixed;
    function findOneByName($categoryName):CategoryInterface;
    function addCategoryUuidToProduct($productUuid);
    function deleteCategoryByProductUuid($uuid);
    function findASetOfByUuids($uuids): CategoryCollection;
}