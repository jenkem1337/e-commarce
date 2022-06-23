<?php

interface ProductInterface {
        function incrementStockQuantity(int $quantity);
        function decrementStockQuantity(int $quantity);
        function changeHeader($header);
    
        function changeDescription($description);
        function setRate(RateInterface $rate);
        function changePrice($price);
        function calculateAvarageRate();
        function isPriceLessThanPreviousPrice();
        function addSubscriber(ProductSubscriberInterface $sub);
        function addCategory(CategoryInterface $category);
        function addRate(RateInterface $rate);
        function addComment(CommentInterface $comment);
        function addImage(ImageInterface $img);
        public function getBrand();
        public function getModel();
    
        public function getPrice();
    
        public function getStockQuantity();
        public function getRate():RateInterface;
    
        public function getComments():CommentCollection;
    
        public function getDescription();
    
        public function getHeader();
        public function getRates():RateCollection;

        public function getImages():ImageCollection;
    
        public function getSubscribers():SubscriberCollection;
    
        public function getCategories():CategoryCollection;

        public function getUuid();

        public function getPreviousPrice();
        public function getCreatedAt();

        public function getUpdatedAt();

        function isNull();

}