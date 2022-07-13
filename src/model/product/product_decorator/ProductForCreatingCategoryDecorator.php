<?php

use Ramsey\Uuid\Uuid;

require './vendor/autoload.php';

class ProductForCreatingCategoryDecorator extends ProductDecorator {
    function __construct()
    {
        parent::__construct(Uuid::uuid4(),'', '', '', '', 0.0 , 0, new NullRate(), date('Y-m-d H:i:s'), date('Y-m-d H:i:s') );
    }
    function incrementStockQuantity(int $quantity){
        throw new Exception();
    }

    function decrementStockQuantity(int $quantity){
        throw new Exception();
    }

    function changeHeader($header){
        throw new Exception();
    }

    function changeDescription($description){
        throw new Exception();
    }
    function setRate(RateInterface $rate){
        throw new Exception();    
    }

    function changePrice($price){
        
        throw new Exception();    
    }

    function isPriceLessThanPreviousPrice(){
        throw new Exception();    
    } 
    function addSubscriber(ProductSubscriberInterface $sub){
        throw new Exception();    
    }
    function addCategory(CategoryInterface $category) {
        if(!$category){
            throw new NullException('category');
        }
        $this->categories->add($category);
    }

    function addComment(CommentInterface $comment){
        throw new Exception();    }
    function addImage(ImageInterface $img){
        throw new Exception();
    }
    function addRate(RateInterface $rate){
        throw new Exception();
    }
    function calculateAvarageRate(){
        throw new Exception();
    }
    protected function getSumOfRate(){
        throw new Exception();    
    }
    /**
     * Get the value of brand
     */ 
    public function getBrand()
    {
        throw new Exception();
    }

    /**
     * Get the value of model
     */ 
    public function getModel()
    {
        throw new Exception();
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        throw new Exception();
    }

    /**
     * Get the value of stockQuantity
     */ 
    public function getStockQuantity()
    {
        throw new Exception();
    }

    /**
     * Get the value of rate
     */ 
    public function getRate():RateInterface
    {
        throw new Exception();
    }

    /**
     * Get the value of comments
     */ 
    public function getComments():CommentCollection
    {
        throw new Exception();
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        throw new Exception();
    }

    /**
     * Get the value of header
     */ 
    public function getHeader()
    {
        throw new Exception();
    }

    
    /**
     * Get the value of images
     */ 
    public function getImages():ImageCollection
    {
        throw new Exception();
    }

    /**
     * Get the value of subscribers
     */ 
    public function getSubscribers():SubscriberCollection
    {
        throw new Exception();
    }

    /**
     * Get the value of categories
     */ 
    public function getCategories():CategoryCollection
    {
        return $this->categories;
    }

    /**
     * Get the value of previousPrice
     */ 
    public function getPreviousPrice()
    {
        throw new Exception();
    }

    /**
     * Get the value of rates
     */ 
    public function getRates():RateCollection
    {
        throw new Exception();
    }

}