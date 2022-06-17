<?php


require "./vendor/autoload.php";
class Product extends BaseEntity implements AggregateRoot{
    private $brand;
    private $model;
    private $header;
    private $description;
    private $price;
    private $stockQuantity;
    private RateInterface $rate;
    private $comments;
    private $comment;
    private $images;
    function __construct($uuid, $brand,$model,$header,$description,$price,$stockQuantity, RateInterface $rate,$images,$createdAt, $updatedAt)
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
            throw new  NullException('price');
        }
        if($price < 0){
            throw new NegativeValueException();
        }
        if(!$stockQuantity){
            throw new NullException("stock quantity");
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
        $this->images = $images;
        
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

    function changePrice($price){
        if(!$price){
            throw new  NullException('price');
        }
        if($price < 0){
            throw new NegativeValueException();
        }

        if($price == $this->price){
            throw new SamePropertyException('new price', 'price');
        }
        $this->price = $price;
    }

    function writeNewComment(Comment $comment){
        if(!$comment){
            throw new NullException("comment");
        }
        $this->comment = $comment;
    }
    

    function setComments(array $comments){
        $this->comments = $comments;
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
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Get the value of comments
     */ 
    public function getComments()
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
     * Get the value of newComment
     */ 
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Get the value of images
     */ 
    public function getImages()
    {
        return $this->images;
    }
}