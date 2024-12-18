<?php

class ProductReviewDto {
    function __construct(
        private $productUuid,
        private $orderUuid,
        private $userUuid,
        private $rate,
        private $comment
    ){}

        /**
         * Get the value of productUuid
         */ 
        public function getProductUuid()
        {
                return $this->productUuid;
        }

        /**
         * Get the value of orderUuid
         */ 
        public function getOrderUuid()
        {
                return $this->orderUuid;
        }

        /**
         * Get the value of rate
         */ 
        public function getRate()
        {
                return $this->rate;
        }

        /**
         * Get the value of comment
         */ 
        public function getComment()
        {
                return $this->comment;
        }

        /**
         * Get the value of userUuid
         */ 
        public function getUserUuid()
        {
                return $this->userUuid;
        }
}