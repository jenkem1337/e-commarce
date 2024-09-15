<?php
interface CommentInterface {
    function changeComment($comment);

    public function getProductUuid();

    public function getUserUuid();

    public function getComment();

    public function getUuid();

    public function getCreatedAt();

    public function getUpdatedAt();
    function setWriterName($writerName);
    function getWriterName();
    function isNull();

}