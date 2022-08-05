<?php
interface CommentRepository {
    function persist(Comment $c);
    function deleteByUuid($uuid);
    function findAll():ArrayIterator;
    function findOneByUuid($uuid): CommentInterface;
    function updateByUuid(Comment $c);
    function findAllByProductUuid($productUuid): ArrayIterator;
    function findAllByUserUuid($userUuid): ArrayIterator;

}