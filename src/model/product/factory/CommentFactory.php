<?php
require "./vendor/autoload.php";
abstract class CommentFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false,...$params):CommentInterface {
        if($isMustBeConcreteObject == true){
            return new Comment(...$params);
        }
        try {
            return new Comment(...$params);
        } catch (\Exception $th) {
            return new NullComment();
        }
    }
}