<?php
interface CommentRepository {
    function persist(Comment $c);
    function deleteByUuid($uuid);
    function deleteAllByProductUuid($productUuid);
    function findAll():IteratorAggregate;
    function findOneByUuid($uuid): CommentInterface;
    function updateByUuid(Comment $c);
    function findAllByProductAggregateUuid($productUuid): IteratorAggregate;
    function findAllByProductUuid($productUuid);
    function findAllByUserUuid($userUuid): IteratorAggregate;

}