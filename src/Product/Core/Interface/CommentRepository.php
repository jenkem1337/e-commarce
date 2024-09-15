<?php
interface CommentRepository {
    function persist(Comment $c);
    function deleteByUuid($uuid);
    function findAll():IteratorAggregate;
    function findOneByUuid($uuid): CommentInterface;
    function updateByUuid(Comment $c);
    function findAllByProductUuid($productUuid): IteratorAggregate;
    function findAllByUserUuid($userUuid): IteratorAggregate;

}