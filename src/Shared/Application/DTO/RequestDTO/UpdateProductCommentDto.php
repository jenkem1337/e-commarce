<?php

class UpdateProductCommentDto {
    function __construct(
        private $productUuid,
        private $userUuid,
        private $newComment
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
        public function getNewComment()
        {
                return $this->newComment;
        }
}