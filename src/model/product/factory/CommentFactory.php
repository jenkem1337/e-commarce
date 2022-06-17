<?php
require "./vendor/autoload.php";
abstract class CommentFactory implements Factory {
    function createInstance(...$params):Comment {
        return new Comment(...$params);
    }
}