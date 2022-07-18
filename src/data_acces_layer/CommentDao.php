<?php

interface CommentDao{
    function persist(Comment $c);
    function deleteByUuid($uuid);
    function findCommentByUuid($uuid);
    function findAll();
    function findOneByUuid($uuid);
    function updateByUuid($uuid);
}