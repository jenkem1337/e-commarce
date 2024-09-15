<?php

class OneProductFoundedResponseDto extends ResponseViewModel implements JsonSerializable {
    protected $uuid;

    protected $brand;

    protected $model;

    protected $header;

    protected $description;

    protected $price;

    protected $avarageRate;

    protected $stockQuantity;

    protected CategoryCollection $categories;

    protected CommentCollection $comments;

    protected RateCollection $rates;

    protected ImageCollection $images;

    protected SubscriberCollection $subscribers;

    protected $createdAt;

    protected $updatedAt;


    public function __construct($uuid, $brand, $model, $header, $description, $price, $avarageRate, $stockQuantity, $categories, $comments, $rates, $images, $subscribers, $createdAt, $updatedAt)
    {
        $this->uuid = $uuid;
        $this->brand = $brand;
        $this->model = $model;
        $this->header = $header;
        $this->description = $description;
        $this->price = $price;
        $this->avarageRate = $avarageRate;
        $this->stockQuantity = $stockQuantity;
        $this->categories = $categories;
        $this->comments = $comments;
        $this->rates = $rates;
        $this->images = $images;
        $this->subscribers = $subscribers;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        parent::__construct('success', $this);
    }



    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get the value of stockQuantity
     */ 
    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }

    /**
     * Get the value of avarageRate
     */ 
    public function getAvarageRate()
    {
        return $this->avarageRate;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
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
     * Get the value of model
     */ 
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get the value of brand
     */ 
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of categories
     */ 
    public function getCategories()
    {
        $categories = [];
        foreach($this->categories as $category){
            $categoryObj = new stdClass;
            $categoryObj->uuid = $category->getUuid();
            $categoryObj->category_name = $category->getCategoryName();
            $categoryObj->created_at = $category->getCreatedAt();
            $categoryObj->updated_at = $category->getUpdatedAt();
            $categories[] = $categoryObj;

        }
        return $categories;
    }

    /**
     * Get the value of comments
     */ 
    public function getComments()
    {
        $commentArr = [];
        foreach($this->comments as $comment){
            $commentObj = new stdClass;
            $commentObj->uuid = $comment->getUuid();
            $commentObj->comment_text = $comment->getComment();
            $commentObj->writer_name = $comment->getWriterName();
            $commentObj->created_at = $comment->getCreatedAt();
            $commentObj->updated_at = $comment->getUpdatedAt();
            $commentArr[] = $commentObj;
        }
        return $commentArr;
    }

    /**
     * Get the value of rates
     */ 
    public function getRates()
    {
        $rateArr = [];
        foreach($this->rates as $rate){
            $rateObj = new stdClass;
            $rateObj->uuid = $rate->getUuid();
            $rateObj->user_uuid = $rate->getUserUuid();
            $rateObj->user_name = $rate->getRateNumber();
            $rateObj->created_at = $rate->getCreatedAt();
            $rateObj->updated_at = $rate->getUpdatedAt();
            $rateArr[] = $rateObj;
        }
        return $rateArr;
    }

    /**
     * Get the value of images
     */ 
    public function getImages()
    {

        $imageArr = [];
        foreach($this->images as $image){
            $imageObj = new stdClass;
            $imageObj->uuid = $image->getUuid();
            $imageObj->image_name = $image->getImageName();
            $imageObj->product_uuid = $image->getProductUuid();
            $imageObj->created_at = $image->getCreatedAt();
            $imageObj->updated_at = $image->getUpdatedAt();
            $imageArr[] = $imageObj;
        }
        
        return $imageArr;
    }

    /**
     * Get the value of subscribers
     */ 
    public function getSubscribers()
    {
        $subscriberArr = [];
        
        foreach( $this->subscribers as $subscriber){
            $subObj = new stdClass;
            $subObj->uuid = $subscriber->getUuid();
            $subObj->subscriber_uuid = $subscriber->getUserUuid();
            $subObj->subscriber_name = $subscriber->getUserFullName();
            $subObj->subscriber_email = $subscriber->getUserEmail();
            $subObj->created_at= $subscriber->getCreatedAt();
            $subObj->updated_at = $subscriber->getUpdatedAt();
            $subscriberArr[] = $subObj;
        }
        return $subscriberArr;
    }

    /**
     * Get the value of shippings
     */ 

    function jsonSerialize(): mixed
    {
        return [
            'uuid'=>$this->getUuid(),
            'brand'=> $this->getBrand(),
            'model' => $this->getModel(),
            'header'=>$this->getHeader(),
            'description'=>$this->getDescription(),
            'price'=>$this->getPrice(),
            'stock_quantity'=>$this->getStockQuantity(),
            'avarage_rate'=>$this->getAvarageRate(),
            'comments'=> $this->getComments(),
            'rates'=>$this->getRates(),
            'subscribers'=>$this->getSubscribers(),
            'categories'=> $this->getCategories(),
            'images'=>$this->getImages(),
            'created_at' => $this->getCreatedAt(),
            'updated_at'=>$this->getUpdatedAt()
        ];
    }
}