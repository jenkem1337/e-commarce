<?php
require './vendor/autoload.php';
class ProductCreatedResponseDto extends ResponseViewModel {
    public function __construct(  
        protected $uuid,  
        protected $brand,
        protected $model,
        protected $header,
        protected $description,
        protected $price,
        protected $stockQuantity,
        protected array $categories,
        protected $createdAt,
        protected $updatedAt
    
    )
        {
            parent::__construct('success', $this);
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
         * Get the value of stockQuantity
         */ 
        public function getStockQuantity()
        {
                return $this->stockQuantity;
        }

        

        /**
         * Get the value of categories
         */ 
        public function getCategories():array
        {
                return $this->categories;
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
         * Get the value of uuid
         */ 
        public function getUuid()
        {
                return $this->uuid;
        }
}