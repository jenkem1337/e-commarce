<?php

interface CategoryRepository {
    function persist(CategoryInterface $c);
    function deleteByUuid($uuid);
    function findByUuid($uuid):CategoryInterface;
    function updateNameByUuid(CategoryInterface $c);
    function findAll():IteratorAggregate;
    function addCategoryUuidToProduct($productUuid);
}