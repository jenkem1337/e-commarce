<?php

abstract class Product extends BaseEntity implements AggregateRoot, ProductInterface{
    protected $brand;
    protected $model;
    protected $header;
    protected $description;
    protected $price;
    protected $stockQuantity;
    protected $avarageRate = 0;
    protected $previousPrice;
    protected RateCollection $rates;
    protected SubscriberCollection $subscribers;
    protected CategoryCollection $categories;
    protected CommentCollection $comments;
    protected ImageCollection $images;
    function __construct($uuid, string $brand = null,string $model = null ,string $header = null, string $description = null, float $price = null ,int $stockQuantity = null,$createdAt, $updatedAt)
    {
        parent::__construct($uuid,$createdAt, $updatedAt);

        $this->brand = $brand;
        $this->model = $model;
        $this->header = $header;
        $this->description = $description;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
        $this->rates       = new RateCollection();
        $this->comments    = new CommentCollection();
        $this->categories  = new CategoryCollection();
        $this->images      = new ImageCollection();
        $this->subscribers = new SubscriberCollection();
    }

    function incrementStockQuantity(int $quantity){
        $quantity = abs($quantity);
        $this->stockQuantity += $quantity;
    }

    function decrementStockQuantity(int $quantity){
        $quantity = abs($quantity);
        $this->stockQuantity -= $quantity;
        if($this->stockQuantity < 0){
            throw new NegativeValueException();
        }
    }
    function changeModel($newModel){
        if(!$newModel) throw new NullException('new model');
        if($this->model == $newModel) throw new SamePropertyException('new model', 'model');
        $this->model = $newModel;
    }
    function changeBrand($newBrand) {
        if(!$newBrand) throw new NullException('new brand');
        if($this->brand == $newBrand) throw new SamePropertyException('new brand','brand');
        $this->brand = $newBrand; 
    }
    function changeHeader($header){
        if(!$header){
            throw new NullException('header');
        }
        if($header == $this->header){
            throw new SamePropertyException('new header', 'header');
        }
        $this->header = $header;
    }

    function changeDescription($description){
        if(!$description){
            throw new NullException('description');
        }
        if($description == $this->description){
            throw new SamePropertyException('new description', 'description');
        }
        $this->description = $description;
    }
    function changePrice($price){
        
        if(!$price){
            throw new NullException('price');
        }
        if($price < 0){
            throw new NegativeValueException();
        }

        if($price == $this->price){
            throw new SamePropertyException('new price', 'price');
        }
        $this->previousPrice = $this->price;
        $this->price = $price;
        $this->appendLog(new UpdateLog($this->getUuid(), "products", [
            "price" => $this->price,
            "prev_price" => $this->previousPrice,
        ]));
    }

    function isPriceLessThanPreviousPrice(){
        return ($this->price < $this->previousPrice) ? true : false;
    } 
    function addSubscriber(ProductSubscriberInterface $sub){
        if(!$sub) throw new NullException('subscriber');
        $this->subscribers->add($sub);
    }
    function addCategory(CategoryInterface $category) {
        if(!$category){
            throw new NullException('category');
        }
        $this->categories->add($category);
    }

    function addComment(CommentInterface $comment){
        if(!$comment){
            throw new NullException("comment");
        }
        $this->comments->add($comment);
    }
    function addImage(ImageInterface $img){
        $this->images->add($img);
    }
    function addRate(RateInterface $rate){
        $this->rates->add($rate);
    }

    function swapSubscribersCollection(IteratorAggregate $i) {
        $this->subscribers = $i;
    }
    function swapCategoryCollection(IteratorAggregate $i) {
        $this->categories = $i;
    }
    function swapImageCollection(IteratorAggregate $i) {
        $this->images = $i;
    }
    function swapRateCollection(IteratorAggregate $i) {
        $this->rates = $i;
    }
    function swapCommentCollection(IteratorAggregate $i) {
        $this->comments = $i;
    }

    function calculateAvarageRate(){
        $howManyPeopleRateIt = count($this->rates->getItems());
        $sumOfRate = $this->getSumOfRate() ?? 0;
        if($sumOfRate === 0){
            $this->avarageRate = 0;
            return;
        }
        if(!$sumOfRate) throw new NullException('sum of rate');
        $this->avarageRate =  $sumOfRate/$howManyPeopleRateIt;
    }
    protected function getSumOfRate(){
        $sumOfRates = 0;
        $rates = $this->rates->getItems();
        foreach($rates as $rate){
            $sumOfRates += $rate->getRateNumber(); 
        }
        return $sumOfRates;
    }
    /**
     * Get the value of brand
     */ 
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Get the value of model
     */ 
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the value of stockQuantity
     */ 
    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }

    /**
     * Get the value of rate
     */ 
    public function getAvarageRate()
    {
        return $this->avarageRate;
    }

    /**
     * Get the value of comments
     */ 
    public function getComments():CommentCollection
    {
        return $this->comments;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of header
     */ 
    public function getHeader()
    {
        return $this->header;
    }

    
    /**
     * Get the value of images
     */ 
    public function getImages():ImageCollection
    {
        return $this->images;
    }

    /**
     * Get the value of subscribers
     */ 
    public function getSubscribers():SubscriberCollection
    {
        return $this->subscribers;
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
        return $this->previousPrice;
    }

    /**
     * Get the value of rates
     */ 
    public function getRates():RateCollection
    {
        return $this->rates;
    }
}