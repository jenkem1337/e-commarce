<?php

require "./vendor/autoload.php";

class NullProduct implements ProductInteface {
    function __construct()
    {
        
    }
    function incrementStockQuantity(int $quantity){}
    function decrementStockQuantity(int $quantity){}
    function changeHeader($header){}

    function changeDescription($description){}

    function changePrice($price){}

    function isPriceLessThanPreviousPrice(){}

    function addCategory(CategoryInterface $category){}

    function addComment(CommentInterface $comment){}

    public function getBrand(){}

    public function getModel(){}

    public function getPrice(){}

    public function getStockQuantity(){}

    public function getRate():RateInterface{
        return new NullRate();
    }

    public function getComments():CommentCollection{
        return new CommentCollection();
    }

    public function getDescription(){}

    public function getHeader(){}

    public function getImages():ImageCollection {
        return new ImageCollection();
    }

    public function getSubscribers():SubscriberCollection{
        return new SubscriberCollection();
    }

    public function getCategories():CategoryCollection{
        return new CategoryCollection();
    }

    public function getUuid(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}

    function isNull(){
        return true;
    }

}