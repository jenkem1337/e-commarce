<?php

interface CategoryRepository {
    function saveChanges(CategoryInterface $category);
    function persist(CategoryInterface $c);
    function deleteByUuid($uuid);
    function findByUuid($uuid):CategoryInterface;
    function findAllByProductAggregateUuid($productUuid):IteratorAggregate;
    function findAllByProductUuid($productUuid);
    function updateNameByUuid(CategoryInterface $c);
    function findAll():mixed;
    function findOneByName($categoryName):CategoryInterface;
    function addCategoryUuidToProduct($productUuid);
    function deleteCategoryByProductUuid($uuid);
    function findASetOfByUuids($uuids): CategoryCollection;
}