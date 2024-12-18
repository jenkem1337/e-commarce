<?php

class UpdateProductRateDto {
    function __construct(
        private $productUuid,
        private $userUuid,
        private $newRate
    )
    {
        
    }

        /**
         * Get the value of productUuid
         */ 
        public function getProductUuid()
        {
                return $this->productUuid;
        }

        /**
         * Get the value of userUuid
         */ 
        public function getUserUuid()
        {
                return $this->userUuid;
        }

        /**
         * Get the value of newComment
         */ 
        public function getNewRate()
        {
                return $this->newRate;
        }
}