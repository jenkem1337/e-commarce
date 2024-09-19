<?php

interface CommentDao{
    function persist(Comment $c);
    function deleteByUuid($uuid);
    function deleteAllByProductUuid($productUuid);
    function findAll();
    function findOneByUuid($uuid);
    function updateByUuid(Comment $c);
    function findAllByProductUuid($productUuid);
    function findAllByUserUuid($userUuid);
}