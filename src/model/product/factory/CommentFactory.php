<?php
require "./vendor/autoload.php";
abstract class CommentFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false,...$params):Comment {
        return new Comment(...$params);
    }
}