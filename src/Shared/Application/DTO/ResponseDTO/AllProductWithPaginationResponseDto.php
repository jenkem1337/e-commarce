<?php

class AllProductWithPaginationResponseDto extends ResponseViewModel implements JsonSerializable{
    protected IteratorAggregate $products;



    public function __construct(IteratorAggregate $products)
    {
        $this->products = $products;
        parent::__construct('success', $this);

    }

    /**
     * Get the value of products
     */ 
    public function getProducts(): IteratorAggregate
    {
        return $this->products;
    }

    /**
     * Get the value of shippings
     */ 
    function jsonSerialize(): mixed
    {
        $response = [];
        foreach($this->getProducts() as $product) {
            $categories = [];
            $comments = [];
            $rates = [];
            $images = [];
            $subscribers = [];
            foreach($product->getCategories() as $category){
                $categoryObj = new stdClass;
                $categoryObj->uuid = $category->getUuid();
                $categoryObj->category_name = $category->getCategoryName();
                $categoryObj->created_at = $category->getCreatedAt();
                $categoryObj->updated_at = $category->getUpdatedAt();
                $categories[] = $categoryObj;  
            }
            foreach($product->getComments() as $comment) {
                $commentObj = new stdClass;
                $commentObj->uuid = $comment->getUuid();
                $commentObj->comment_text = $comment->getComment();
                $commentObj->writer_name = $comment->getWriterName();
                $commentObj->created_at = $comment->getCreatedAt();
                $commentObj->updated_at = $comment->getUpdatedAt();
                $comments[] = $commentObj;
            }
            foreach($product->getRates() as $rate) {
                $rateObj = new stdClass;
                $rateObj->uuid = $rate->getUuid();
                $rateObj->user_uuid = $rate->getUserUuid();
                $rateObj->user_name = $rate->getRateNumber();
                $rateObj->created_at = $rate->getCreatedAt();
                $rateObj->updated_at = $rate->getUpdatedAt();
                $rates[] = $rateObj;
            }
            foreach($product->getImages() as $image) {
                $imageObj = new stdClass;
                $imageObj->uuid = $image->getUuid();
                $imageObj->image_name = $image->getImageName();
                $imageObj->product_uuid = $image->getProductUuid();
                $imageObj->created_at = $image->getCreatedAt();
                $imageObj->updated_at = $image->getUpdatedAt();
                $images[] = $imageObj;
            }
            foreach($product->getSubscribers() as $subscriber) {
                $subObj = new stdClass;
                $subObj->uuid = $subscriber->getUuid();
                $subObj->subscriber_uuid = $subscriber->getUserUuid();
                $subObj->subscriber_name = $subscriber->getUserFullName();
                $subObj->subscriber_email = $subscriber->getUserEmail();
                $subObj->created_at= $subscriber->getCreatedAt();
                $subObj->updated_at = $subscriber->getUpdatedAt();
                $subscribers[] = $subObj;
    
            }
            $response[] = [
                'uuid'=>$product->getUuid(),
                'brand'=> $product->getBrand(),
                'model' => $product->getModel(),
                'header'=>$product->getHeader(),
                'description'=>$product->getDescription(),
                'price'=>$product->getPrice(),
                'stock_quantity'=>$product->getStockQuantity(),
                'avarage_rate'=>$product->getAvarageRate(),
                'comments'=>$comments,
                'rates'=>$rates,
                'subscribers'=>$subscribers,
                'categories'=>$categories,
                'images'=>$images,
                'created_at' => $product->getCreatedAt(),
                'updated_at'=>$product->getUpdatedAt()
            ];
        }
        return $response;
    }
}