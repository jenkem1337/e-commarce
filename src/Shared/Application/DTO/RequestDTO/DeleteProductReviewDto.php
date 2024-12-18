<?php

class DeleteProductReviewDto {
    function __construct(
        private $productUuid,
        private $userUuid,
    ){}


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
}