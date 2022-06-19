<?php

require "./vendor/autoload.php";

class NullProduct implements ProductInteface {
    function __construct()
    {
        
    }
    function incrementStockQuantity(int $quantity){}

    function changeHeader($header){}

    function changeDescription($description){}

    function changePrice($price){}

    function isPriceLessThanPreviousPrice(){}

    function createNewCategory(Category $category){}

    function writeNewComment(Comment $comment){}

    function setCategories(array $categories){}

    function setComments(array $comments){}

    public function getBrand(){}

    public function getModel(){}

    public function getPrice(){}

    public function getStockQuantity(){}

    public function getRate(){}

    public function getComments(){}

    public function getDescription(){}

    public function getHeader(){}

    public function getComment(){}

    public function getImages(){}

    public function getSubscribers(){}

    public function getCategories(){}

    public function getCategory(){}

    public function getUuid(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}

    function isNull(){
        return true;
    }

}