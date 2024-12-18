<?php

interface CommentDao{
    function deleteByUuid($uuid);
    function deleteAllByProductUuid($productUuid);
    function findAll();
    function findOneByUuid($uuid);
    function findAllByProductUuid($productUuid);
    function findAllByUserUuid($userUuid);
    function findOneByProductUuidAndUserUuid($productUuid, $userUuid);
}