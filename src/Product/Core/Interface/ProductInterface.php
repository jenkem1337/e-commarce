<?php

interface ProductInterface {
        function incrementStockQuantity(int $quantity);
        function decrementStockQuantity(int $quantity);
        function calculateAvarageRate();
        function changeDetails($model, $brand, $header, $description, $price);
        function isPriceLessThanPreviousPrice();
        function subscribeToProduct($userUuid);
        function unSubscribeToProduct($userUuid);
        function addSubscriber(ProductSubscriberInterface $sub);
        function addCategory(CategoryInterface $category);
        function addCategories(CategoryCollection $categoryCollection);
        function addRate(RateInterface $rate);
        function addComment(CommentInterface $comment);
        function addImage(ImageInterface $img);
        function addImages($images);
        function deleteImage($imageUuid):ImageInterface;
        function swapSubscribersCollection(IteratorAggregate $i);
        function swapCategoryCollection(IteratorAggregate $i);
        function swapRateCollection(IteratorAggregate $i);
        function swapCommentCollection(IteratorAggregate $i);
        function swapImageCollection(IteratorAggregate $i);


        public function getBrand();
        public function getModel();
    
        public function getPrice();
    
        public function getStockQuantity();
        public function getAvarageRate();
    
        public function getComments():CommentCollection;
    
        public function getDescription();
    
        public function getHeader();
        public function getRates():RateCollection;

        public function getImages():ImageCollection;
    
        public function getSubscribers():SubscriberCollection;
    
        public function getCategories():CategoryUuidCollection;

        public function getUuid();

        public function getPreviousPrice();
        public function getCreatedAt();

        public function getUpdatedAt();

        function isNull();

}