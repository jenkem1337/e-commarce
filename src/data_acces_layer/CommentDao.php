<?php

interface CommentDao{
    function persist(Comment $c);
    function deleteByUuid($uuid);
    function findAll();
    function findOneByUuid($uuid);
    function updateByUuid($uuid, $updatedComment);
    function findAllByProductUuid($productUuid);
    function findAllByUserUuid($userUuid);
}