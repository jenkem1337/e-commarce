<?php
interface CommentRepository {
    function deleteByUuid($uuid);
    function deleteAllByProductUuid($productUuid);
    function findAll():IteratorAggregate;
    function findOneByUuid($uuid): CommentInterface;
    function findAllByProductAggregateUuid($productUuid): IteratorAggregate;
    function findAllByProductUuid($productUuid);
    function findAllByUserUuid($userUuid): IteratorAggregate;
    function findOneByProductUuidAndUserUuid($productUuid, $userUuid):CommentInterface;

}