<?php
class ProductDetailDto {
    private $brand;
    private $model;
    private $header;
    private $description;
    private $price;
    
    private $uuid;

    function __construct($uuid, $brand, $model, $header, $description, $price){
        $this->brand = $brand;
        $this->model = $model;
        $this->header = $header;
        $this->description = $description;
        $this->price = $price;
        $this->uuid = $uuid;
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
     * Get the value of header
     */ 
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }
}