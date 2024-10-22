<?php
use Ramsey\Uuid\Uuid;
class Product extends BaseEntity implements AggregateRoot, ProductInterface{
    protected $brand;
    protected $model;
    protected $header;
    protected $description;
    protected $price;
    protected $stockQuantity;
    protected $avarageRate = 0;
    protected $previousPrice;
    protected RateCollection $rates;
    protected SubscriberCollection $subscribers;
    protected CategoryUuidCollection $categories;
    protected CommentCollection $comments;
    protected ImageCollection $images;
    function __construct($uuid, string $brand = null,string $model = null ,string $header = null, string $description = null, float $price = null ,int $stockQuantity = null,$createdAt, $updatedAt)
    {
        parent::__construct($uuid,$createdAt, $updatedAt);
        if(!$brand){
            throw new NullException("brand");
        }
        if(!$model){
            throw new NullException("model");
        }
        if(!$header){
            throw new NullException("header");
        }
        if(!$description){
            throw new NullException("description");
        }
        if(!$price){
            throw new NullException('price');
        }
        if($price < 0){
            throw new NegativeValueException();
        }
        if($stockQuantity<0){
            throw new NegativeValueException();
        }

        $this->brand = $brand;
        $this->model = $model;
        $this->header = $header;
        $this->description = $description;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
        $this->rates       = new RateCollection();
        $this->comments    = new CommentCollection();
        $this->categories  = new CategoryUuidCollection();
        $this->images      = new ImageCollection();
        $this->subscribers = new SubscriberCollection();
    }
    public static function newInstance($uuid, $brand,$model, $header,  $description, $price, $stockQuantity, $createdAt, $updatedAt):ProductInterface {
        try {
            
    
            return new Product($uuid, $brand,$model, $header,  $description, $price, $stockQuantity, $createdAt, $updatedAt);
        } catch (\Throwable $th) {
            return new NullProduct();
        }
    }
    public static function newStrictInstance($uuid, $brand,$model, $header,  $description, $price, $stockQuantity, $createdAt, $updatedAt):ProductInterface{
        return new Product($uuid, $brand,$model, $header,  $description, $price, $stockQuantity, $createdAt, $updatedAt);
    }
    public static function createNewProduct($uuid, $brand,$model, $header,  $description, $price, $stockQuantity) {

        $product =  new Product($uuid, $brand,$model, $header,  $description, $price, $stockQuantity, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
        $product->appendLog(new InsertLog("products", [
            "uuid" => $product->getUuid(),
            "brand_uuid" => $product->getBrand(),
            "model_uuid" => $product->getModel(),
            "header" => $product->getHeader(),
            "_description" => $product->getDescription(),
            "price" => $product->getPrice(),
            "stockquantity" => $product->getStockQuantity(),
            "rate" => null,
            "prev_price" => null,
            "created_at" => $product->getCreatedAt(),
            "updated_at" => $product->getUpdatedAt()
        ]));
        return $product;
    }
    function incrementStockQuantity(int $quantity){
        $quantity = abs($quantity);
        $this->stockQuantity += $quantity;
        $this->appendLog(new UpdateLog( "products", [
            "setter" => [
                "stockquantity" => $this->stockQuantity,
                "updated_at" => date('Y-m-d H:i:s')

            ],
            "whereCondation" => [
                "uuid" => $this->getUuid()
            ]
        ]));
    }

    function decrementStockQuantity(int $quantity){
        $quantity = abs($quantity);
        $this->stockQuantity -= $quantity;
        if($this->stockQuantity < 0){
            throw new NegativeValueException();
        }
        $this->appendLog(new UpdateLog( "products", [
            "setter" => [
                "stockquantity" => $this->stockQuantity,
                "updated_at" => date('Y-m-d H:i:s')

            ],
            "whereCondation" => [
                "uuid" => $this->getUuid()
            ]
        ]));
    }
    function changeDetails($model, $brand, $header, $description, $price){
        self::checkModel($model);
        self::checkBrand($brand);
        self::checkHeader($header);
        self::checkDescription($description);
        self::checkPrice($price);
        
        $this->brand = trim($brand);
        $this->model = trim($model);
        $this->header = trim($header);
        $this->description = trim($description);
        $this->previousPrice = $this->price;
        $this->price = $price;
        
        $this->appendLog(new UpdateLog("products", [
            "setter" => [
                "brand_uuid" => $this->brand,
                "model_uuid" => $this->model,
                "header" => $this->header,
                "_description" => $this->description,
                "price" => $this->price,
                "prev_price" => $this->previousPrice,
                "updated_at" => date('Y-m-d H:i:s')
            ],
            "whereCondation" => [
                "uuid" => $this->getUuid()
            ]
        ]));
    }
    private function checkModel($newModel){
        if(!trim($newModel)) 
                    throw new NullException('new model');        
    }
    private function checkBrand($newBrand) {
        if(!trim($newBrand)) 
                    throw new NullException('new brand');
        
    }
    private function checkHeader($header){
        if(!trim($header)){
            throw new NullException('header');
        }
    }

    private function checkDescription($description){
        if(!trim($description)){
            throw new NullException('description');
        }   
    }
    private function checkPrice($price){
        
        if(!$price){
            throw new NullException('price');
        }
        if($price < 0){
            throw new NegativeValueException();
        }
    }

    function isPriceLessThanPreviousPrice(){
        return ($this->price < $this->previousPrice) ? true : false;
    }
    function subscribeToProduct($userUuid){
        if(count($this->getSubscribers()->getItems()) == 1){
            throw new AlreadyExistException('product subscriber');
        }
        
        $productSubscriber = ProductSubscriber::newStrictInstance(UUID::uuid4(), $this->getUuid(), $userUuid, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
        
        $this->addSubscriber($productSubscriber);
        
        $this->appendLog(new InsertLog("product_subscriber", [
            "uuid" => UUID::uuid4(),
            "user_uuid" => $productSubscriber->getUserUuid(),
            "product_uuid" => $this->getUuid(),
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        ]));
    }
    function unSubscribeToProduct($userUuid) {
        if((count($this->getSubscribers()->getItems()) == 1) ){
            $this->appendLog(new DeleteLog("product_subscriber", [
            "whereCondation" => [
                    "user_uuid" => $userUuid,
                    "product_uuid" => $this->getUuid()
                ]
            ]));
        } else {
            throw new DoesNotExistException('Your subscription');
        }    
    }
    function addSubscriber(ProductSubscriberInterface $sub){
        if(!$sub) throw new NullException('subscriber');
        $this->subscribers->add($sub);
    }
    function addCategory(CategoryInterface $category) {
        if(!$category){
            throw new NullException('category');
        }
        $this->categories->add($category);
        $this->appendLog(new InsertLog("product_category", [
            "uuid" => UUID::uuid4(),
            "product_uuid" => $this->getUuid(),
            "category_uuid" => $category->getUuid(),
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        ]));
    }
    function addCategories(CategoryCollection $categoryCollection) {
        if(count($categoryCollection->getItems()) == 0){
            throw new NotFoundException("Category(ies)");
        }

        foreach($categoryCollection->getItems() as $category){
            $this->addCategory($category);            
        }

    }
    function addComment(CommentInterface $comment): void{
        if(!$comment){
            throw new NullException("comment");
        }
        $this->comments->add($comment);
    }
    function addImage(ImageInterface $img){
        $this->images->add($img);
    }

    function addImages($images) {
        for($i = 0; $i < count($images["name"]); $i++) {
            $imageDomainObject= Image::newStrictInstance(
                UUID::uuid4(),
                $this->getUuid(),
                $images['name'][$i],
                $this->getUuid()."/".$images['name'][$i],
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s'),
            );
            $this->images->add($imageDomainObject);
            $this->appendLog(new InsertLog("image", [
                "uuid" => $imageDomainObject->getUuid(),
                "image_name" => $imageDomainObject->getImageName(),
                "product_uuid" => $this->getUuid(),
                "location" => $imageDomainObject->getLocation(),
                "created_at" => $imageDomainObject->getCreatedAt(),
                "updated_at" => $imageDomainObject->getUpdatedAt()
            ]));
        }
    }
    function deleteImage($imageUuid): ImageInterface{
        $image = $this->images->getItem($imageUuid);
        if($image->isNull()) {
            throw new DoesNotExistException('image');
        }
        $this->appendLog(new DeleteLog("image", [
            "whereCondation" => [
                "uuid" => $imageUuid
            ] 
        ]));
        return $image;
    }
    function addRate(RateInterface $rate){
        $this->rates->add($rate);
    }

    function swapSubscribersCollection(IteratorAggregate $i) {
        $this->subscribers = $i;
    }
    function swapCategoryCollection(IteratorAggregate $i) {
        $this->categories = $i;
    }
    function swapImageCollection(IteratorAggregate $i) {
        $this->images = $i;
    }
    function swapRateCollection(IteratorAggregate $i) {
        $this->rates = $i;
    }
    function swapCommentCollection(IteratorAggregate $i) {
        $this->comments = $i;
    }

    function calculateAvarageRate(){
        $howManyPeopleRateIt = count($this->rates->getItems());
        $sumOfRate = $this->getSumOfRate() ?? 0;
        if($sumOfRate === 0){
            $this->avarageRate = 0;
            return;
        }
        if(!$sumOfRate) throw new NullException('sum of rate');
        $this->avarageRate =  $sumOfRate/$howManyPeopleRateIt;
    }
    protected function getSumOfRate(){
        $sumOfRates = 0;
        $rates = $this->rates->getItems();
        foreach($rates as $rate){
            $sumOfRates += $rate->getRateNumber(); 
        }
        return $sumOfRates;
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
     * Get the value of rate
     */ 
    public function getAvarageRate()
    {
        return $this->avarageRate;
    }

    /**
     * Get the value of comments
     */ 
    public function getComments():CommentCollection
    {
        return $this->comments;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of header
     */ 
    public function getHeader()
    {
        return $this->header;
    }

    
    /**
     * Get the value of images
     */ 
    public function getImages():ImageCollection
    {
        return $this->images;
    }

    /**
     * Get the value of subscribers
     */ 
    public function getSubscribers():SubscriberCollection
    {
        return $this->subscribers;
    }

    /**
     * Get the value of categories
     */ 
    public function getCategories():CategoryUuidCollection
    {
        return $this->categories;
    }

    /**
     * Get the value of previousPrice
     */ 
    public function getPreviousPrice()
    {
        return $this->previousPrice;
    }

    /**
     * Get the value of rates
     */ 
    public function getRates():RateCollection
    {
        return $this->rates;
    }
}