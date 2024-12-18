<?php

class ProductRepositoryImpl extends TransactionalRepository implements ProductRepository{
    private ?ProductDao $productDao;
    private ?ProductSubscriberRepository $productSubscriberRepository;
    private ?CommentRepository $commentRepository;
    private ?RateRepository $rateRepository;
    private ?ImageRepository $imageRepository;
	function __construct(
        ProductDao $productDao = null,
        ProductSubscriberRepository $productSubscriberRepository = null,
        CommentRepository $commentRepository = null,
        RateRepository $rateRepository = null,
        ImageRepository $imageRepository = null) {
        $this->productDao = $productDao;
        $this->productSubscriberRepository = $productSubscriberRepository;
        $this->commentRepository = $commentRepository;
        $this->rateRepository = $rateRepository;
        $this->imageRepository = $imageRepository;
        parent::__construct($this->productDao);
	}
    static function newInstaceWithOnlyImageRepository(ProductDao $productDao, ImageRepository $imageRepository) {
        return new ProductRepositoryImpl($productDao, null, null, null, $imageRepository);
    }
    function saveChanges($e){
        $this->productDao->saveChanges($e);
    }
    private function getManyProductEntityFromSubEntitiesForReads($productObjects, $filter){
        foreach($productObjects as $productObject){ 
            
 
            if($filter["subscribers"] == "get"){
                $subscriberCollection = $this->productSubscriberRepository->findAllProductSubscriberByProductUuid($productObject->uuid);
                $productObject->subscriers = $subscriberCollection;
            }
                
            if($filter["comments"] == "get"){
                $commentIterator  = $this->commentRepository->findAllByProductUuid($productObject->uuid);
                $productObject->comments = $commentIterator;
            }
            //if($filter["categories"] == "get"){
            //    $categoryIterator = $this->categoryRepository->findAllByProductUuid($productObject->uuid);
            //    $productObject->categories = $categoryIterator;
            //}
            if($filter["rates"] == "get"){
                $rateIterator     = $this->rateRepository->findAllByProductUuid($productObject->uuid);
                $productObject->rates = $rateIterator;
            }
            if($filter["images"] == "get"){
                $imageIterator    = $this->imageRepository->findAllByProductUuid($productObject->uuid);
                $productObject->images = $imageIterator;
            }
        }
        return $productObjects;
    }
    function findProductsByCriteria(FindProductsByCriteriaDto $findProductsByCriteriaDto)
    {
        $productObjects = $this->productDao->findProductsByCriteria($findProductsByCriteriaDto);
        return $this->getManyProductEntityFromSubEntitiesForReads($productObjects, $findProductsByCriteriaDto->getFilters());
    }
    function findOneProductByUuid($uuid, $filter) {
        $productObject    = $this->productDao->findOneByUuid($uuid);
                
        if($filter["subscribers"] == "get"){
            $subscriberCollection = $this->productSubscriberRepository->findAllProductSubscriberByProductUuid($productObject->uuid);
            $productObject->subscriers = $subscriberCollection;

        }
            
        if($filter["comments"] == "get"){
            $commentIterator  = $this->commentRepository->findAllByProductUuid($productObject->uuid);
            $productObject->comments = $commentIterator;

        }
        //if($filter["categories"] == "get"){
        //    $categoryIterator = $this->categoryRepository->findAllByProductAggregateUuid($productObject->uuid);
        //    $productObject->categories = $categoryIterator;
        //}
        if($filter["rates"] == "get"){
            $rateIterator     = $this->rateRepository->findAllByProductUuid($productObject->uuid);
            $productObject->rates = $rateIterator;
        }
        if($filter["images"] == "get"){
            $imageIterator    = $this->imageRepository->findAllByProductUuid($productObject->uuid);
            $productObject->images = $imageIterator;
        }
        return $productObject;
    }
    function findOneProductAggregateByUuid($uuid, $filter): ProductInterface
    {
        $productObject    = $this->productDao->findOneByUuid($uuid);
        
        $productDomainObject = Product::newInstance(

            $productObject->uuid,
            $productObject->brand_uuid,
            $productObject->model_uuid,
            $productObject->header,
            $productObject->_description,
            $productObject->price,
            $productObject->stockquantity,
            $productObject->created_at,
            $productObject->updated_at
        );

        
        if($filter["subscribers"] == "get"){
            $subscriberCollection = $this->productSubscriberRepository->findAllProductSubscriberByProductAggregateUuid($productObject->uuid);
            $productDomainObject->swapSubscribersCollection($subscriberCollection);
        }
            
        if($filter["comments"] == "get"){
            $commentIterator  = $this->commentRepository->findAllByProductAggregateUuid($productObject->uuid);
            $productDomainObject->swapCommentCollection($commentIterator);
        }
        //if($filter["categories"] == "get"){
        //    $categoryIterator = $this->categoryRepository->findAllByProductAggregateUuid($productObject->uuid);
        //    $productDomainObject->swapCategoryCollection($categoryIterator);   
        //}
        if($filter["rates"] == "get"){
            $rateIterator     = $this->rateRepository->findAllByProductAggregateUuid($productObject->uuid);
            $productDomainObject->swapRateCollection($rateIterator);
            $productDomainObject->calculateAvarageRate();
        }
        if($filter["images"] == "get"){
            $imageIterator    = $this->imageRepository->findAllByProductAggregateUuid($productObject->uuid);
            $productDomainObject->swapImageCollection($imageIterator);
        }
        return $productDomainObject;
    }
    
    function findProductsBySearch($searchValue, $startingLimit, $perPageForProduct, $filter)
    {
        $productObjects = $this->productDao->findBySearching($searchValue, $startingLimit, $perPageForProduct);
        return $this->getManyProductEntityFromSubEntitiesForReads($productObjects, $filter);
    }
    
    function deleteProductByUuid(Product $product)
    {
        $this->commentRepository->deleteAllByProductUuid($product->getUuid());
        $this->rateRepository->deleteAllByProductUuid($product->getUuid());
        $this->imageRepository->deleteAllByProductUuid($product->getUuid());
        $this->productSubscriberRepository->deleteByProductUuid($product->getUuid());
        //$this->categoryRepository->deleteCategoryByProductUuid($product->getUuid());
        
        $this->productDao->deleteByUuid($product->getUuid());
    }
    
    function findOneProductWithOnlySubscriberByUuid($uuid, $userUuid): ProductInterface{
        $productObject = $this->productDao->findOneByUuid($uuid);
        $productSubscriberDomainObject = $this->productSubscriberRepository->findOneOrEmptySubscriberByUuid($productObject->uuid, $userUuid);
        $productDomainObject = Product::newInstance(
            $productObject->uuid,
            $productObject->brand_uuid,
            $productObject->model_uuid,
            $productObject->header,
            $productObject->_description,
            $productObject->price,
            $productObject->stockquantity,
            $productObject->created_at,
            $productObject->updated_at
        );
        if(!$productSubscriberDomainObject->isNull()){
            $productDomainObject->addSubscriber($productSubscriberDomainObject);
        }
        return $productDomainObject;
    }

    function findManyAggregateByUuids($uuids): ProductCollection {
        $productObjects = $this->productDao->findManyByUuids($uuids);
        $productCollection = new ProductCollection();
        foreach($productObjects as $productObject) {
            $product = Product::newInstance(
                $productObject->uuid,
                $productObject->brand_uuid,
                $productObject->model_uuid,
                $productObject->header,
            $productObject->_description,
            $productObject->price,
            $productObject->stockquantity,
            $productObject->created_at,
            $productObject->updated_at
            );
            $productCollection->add($product);
        }
        return $productCollection;
    }
    
    function findOneAggregateWithCommentAndRateByProductAndUserUuid($productUuid, $userUuid):ProductInterface{
        $rate = $this->rateRepository->findOneByProductUuidAndUserUuid($productUuid, $userUuid);
        $comment = $this->commentRepository->findOneByProductUuidAndUserUuid($productUuid, $userUuid);
        
        $productObject = $this->productDao->findOneByUuid($productUuid);

        $productAggregate = Product::newInstance(
                            $productObject->uuid,
                            $productObject->brand_uuid,
                            $productObject->model_uuid,
                            $productObject->header,
                            $productObject->_description,
                            $productObject->price,
                            $productObject->stockquantity,
                            $productObject->created_at,
                            $productObject->updated_at
                        );
        $productAggregate->addComment($comment);
        $productAggregate->addRate($rate);

        return $productAggregate;
    }

    function findOneAggregateWithCommentByProductAndUserUuid($productUuid, $userUuid):ProductInterface{
        $comment = $this->commentRepository->findOneByProductUuidAndUserUuid($productUuid, $userUuid);
        
        $productObject = $this->productDao->findOneByUuid($productUuid);

        $productAggregate = Product::newInstance(
                            $productObject->uuid,
                            $productObject->brand_uuid,
                            $productObject->model_uuid,
                            $productObject->header,
                            $productObject->_description,
                            $productObject->price,
                            $productObject->stockquantity,
                            $productObject->created_at,
                            $productObject->updated_at
                        );
        $productAggregate->addComment($comment);

        return $productAggregate;

    }
    function findOneAggregateWithRateByProductAndUserUuid($productUuid, $userUuid):ProductInterface{
        $rate = $this->rateRepository->findOneByProductUuidAndUserUuid($productUuid, $userUuid);
        
        $productObject = $this->productDao->findOneByUuid($productUuid);

        $productAggregate = Product::newInstance(
                            $productObject->uuid,
                            $productObject->brand_uuid,
                            $productObject->model_uuid,
                            $productObject->header,
                            $productObject->_description,
                            $productObject->price,
                            $productObject->stockquantity,
                            $productObject->created_at,
                            $productObject->updated_at
                        );
        $productAggregate->addRate($rate);

        return $productAggregate;

    }

}