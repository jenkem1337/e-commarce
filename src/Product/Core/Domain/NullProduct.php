<?php


class NullProduct implements ProductInterface {
    function __construct()
    {
        
    }
    function swapCategoryCollection(IteratorAggregate $i){}
    function swapCommentCollection(IteratorAggregate $i){}
    function swapImageCollection(IteratorAggregate $i){}
    function swapRateCollection(IteratorAggregate $i){}
    function swapSubscribersCollection(IteratorAggregate $i) {}
    function incrementStockQuantity(int $quantity){}
    function decrementStockQuantity(int $quantity){}
    function changeDetails($model, $brand, $header, $description, $price){}
    function calculateAvarageRate(){}
    function isPriceLessThanPreviousPrice(){}

    function addCategory(CategoryInterface $category){}
    public function getRates():RateCollection{
        return new RateCollection();
    }

    function addComment(CommentInterface $comment){}
    function addCategories(CategoryCollection $categoryCollection){}
    function subscribeToProduct($userUuid){}
    function unSubscribeToProduct($userUuid){}
    function addSubscriber(ProductSubscriberInterface $sub){}

    function addImage(ImageInterface $img){}

    public function getBrand(){}

    public function getModel(){}

    public function getPrice(){}

    public function getStockQuantity(){}
    function setRate(RateInterface $rate){}
    public function getAvarageRate(){
        
    }
    function addRate(RateInterface $rate){}

    public function getComments():CommentCollection{
        return new CommentCollection();
    }

    public function getDescription(){}

    public function getHeader(){}

    public function getImages():ImageCollection {
        return new ImageCollection();
    }

    public function getSubscribers():SubscriberCollection{
        return new SubscriberCollection();
    }

    public function getCategories():CategoryUuidCollection{
        return new CategoryUuidCollection();
    }
    function getPreviousPrice(){}
    public function getUuid(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}

    function isNull(){
        return true;
    }

	function changeBrand($newBrand) {
	}
	
	function changeModel($newModel) {
	}
}