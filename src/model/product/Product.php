<?php


require "./vendor/autoload.php";
class Product extends BaseEntity implements AggregateRoot, ProductInterface{
    private $brand;
    private $model;
    private $header;
    private $description;
    private $price;
    private $stockQuantity;
    private RateInterface $rate;
    private $previousPrice;
    private RateCollection $rates;
    private SubscriberCollection $subscribers;
    private CategoryCollection $categories;
    private CommentCollection $comments;
    private ImageCollection $images;
    function __construct($uuid, string $brand,string $model,string $header, string $description, float $price,int $stockQuantity,RateInterface $rate,$createdAt, $updatedAt)
    {
        parent::__construct($uuid,$createdAt, $updatedAt);
        if(!$brand){
            throw new NullException("brand");
        }
        if(!$model){
            throw new NullException("model");
        }
        if(!$header){
            throw new NullException("header");
        }
        if(!$description){
            throw new NullException("description");
        }
        if(!$price){
            throw new NullException('price');
        }
        if($price < 0){
            throw new NegativeValueException();
        }
        if($stockQuantity<0){
            throw new NegativeValueException();
        }
        if(!$rate){
            throw new NullException('rate');
        }

        $this->brand = $brand;
        $this->model = $model;
        $this->header = $header;
        $this->description = $description;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
        $this->rate = $rate;
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
    function setRate(RateInterface $rate){
        if(!$rate){
            throw new NullException('rate');
        }
        $this->rate = $rate;
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
    function calculateAvarageRate(){
        $howManyPeopleRateIt = count($this->rates->getItems());
        $this->rate->setHowManyPeopleRateIt($howManyPeopleRateIt);
        $this->rate->calculateAvarageRate($this->getSumOfRate());
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
    public function getRate():RateInterface
    {
        return $this->rate;
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