<?php

class ProductRepositoryImpl extends AbstractProductRepositoryMediatorComponent implements ProductRepository{
    private ProductDao $productDao;
    private ProductSubscriberFactory $productSubscriberFactory;
    private ProductFactoryContext $productFactoryContext;
	function __construct(
        ProductFactoryContext $productFactoryContext,
        Factory $productSubscriberFactory,
        ProductDao $productDao) {
        $this->productFactoryContext = $productFactoryContext;
        $this->productSubscriberFactory = $productSubscriberFactory;
        $this->productDao = $productDao;
	}
    private function getManyProductDomainModelFromSubEntities($productObjects, $filter): IteratorAggregate{
        $productCollection = new ProductCollection();
        foreach($productObjects as $productObject){ 
            
            $productDomainObject = $this->productFactoryContext->executeFactory(
                ProductFactory::class,
                false,
                $productObject->uuid,
                $productObject->brand,
                $productObject->model,
                $productObject->header,
                $productObject->_description,
                $productObject->price,
                $productObject->stockquantity,
                $productObject->created_at,
                $productObject->updated_at
            );
 
            if($filter["subscribers"] == "get"){
                $productSubscriberObjects = $this->productDao->findAllProductSubscriberByProductUuid($productObject->uuid);
                $subscriberIterator = new SubscriberCollection();
    
                foreach($productSubscriberObjects as $subscriber){
                    $productSubscriberDomainObject = $this->productSubscriberFactory->createInstance(
                        false,
                        $subscriber->uuid,
                        $subscriber->product_uuid,
                        $subscriber->user_uuid,
                        $subscriber->created_at,
                        $subscriber->updated_at
                    );
    
                    $productSubscriberDomainObject->setUserEmail($subscriber->user_email);
                    $productSubscriberDomainObject->setUserFullName($subscriber->user_full_name);
                    
                    if(!$productSubscriberDomainObject->isNull()) {
                        $subscriberIterator->add($productSubscriberDomainObject);
                    }
                }
                $productDomainObject->swapSubscribersCollection($subscriberIterator);
    
            }
                
            if($filter["comments"] == "get"){
                $commentIterator  = $this->commentRepository->findAllByProductUuid($productObject->uuid);
                $productDomainObject->swapCommentCollection($commentIterator);
            }
            if($filter["categories"] == "get"){
                $categoryIterator = $this->categoryRepository->findAllByProductUuid($productObject->uuid);
                $productDomainObject->swapCategoryCollection($categoryIterator);   
            }
            if($filter["rates"] == "get"){
                $rateIterator     = $this->rateRepository->findAllByProductUuid($productObject->uuid);
                $productDomainObject->swapRateCollection($rateIterator);
                $productDomainObject->calculateAvarageRate();
            }
            if($filter["images"] == "get"){
                $imageIterator    = $this->imageRepository->findAllByProductUuid($productObject->uuid);
                $productDomainObject->swapImageCollection($imageIterator);
            }
            if(!$productDomainObject->isNull()){
                $productCollection->add($productDomainObject);
            }
        }
        return $productCollection;
    }
    function createProduct(Product $p)
    {
        $categories = $p->getCategories()->getItems();
        $this->productDao->persist($p);
        foreach($categories as $category){
            $this->categoryRepository->addCategoryUuidToProduct($category);
        }
    }
    function persistProductSubscriber(Product $p)
    {
        foreach($p->getSubscribers()->getItems() as $subscriber){
            $this->productDao->persistSubscriber($subscriber);
        }
    }
    function findProductsByPriceRange($from, $to, $filter):IteratorAggregate
    {
        $productObjects = $this->productDao->findByPriceRange($from, $to);
        return $this->getManyProductDomainModelFromSubEntities($productObjects, $filter);
    }
    function findAllWithPagination($startingLimit, $perPageForProduct, $filter): IteratorAggregate
    {
        $productObjects = $this->productDao->findAllWithPagination($startingLimit, $perPageForProduct);
        return $this->getManyProductDomainModelFromSubEntities($productObjects, $filter);
    }
    function findAllProducts($filter): IteratorAggregate
    {
        $productObjects = $this->productDao->findAll();
        return $this->getManyProductDomainModelFromSubEntities($productObjects, $filter);
    }
    function findOneProductByUuid($uuid, $filter): ProductInterface
    {
        $productObject    = $this->productDao->findOneByUuid($uuid);
        
        $productDomainObject = $this->productFactoryContext->executeFactory(
            ProductFactory::class,
            false,
            $productObject->uuid,
            $productObject->brand,
            $productObject->model,
            $productObject->header,
            $productObject->_description,
            $productObject->price,
            $productObject->stockquantity,
            $productObject->created_at,
            $productObject->updated_at
        );

        $productSubscriberObjects = $this->productDao->findAllProductSubscriberByProductUuid($uuid);
        
        if($filter["subscribers"] == "get"){
            $productSubscriberObjects = $this->productDao->findAllProductSubscriberByProductUuid($productObject->uuid);
            $subscriberIterator = new SubscriberCollection();

            foreach($productSubscriberObjects as $subscriber){
                $productSubscriberDomainObject = $this->productSubscriberFactory->createInstance(
                    false,
                    $subscriber->uuid,
                    $subscriber->product_uuid,
                    $subscriber->user_uuid,
                    $subscriber->created_at,
                    $subscriber->updated_at
                );

                $productSubscriberDomainObject->setUserEmail($subscriber->user_email);
                $productSubscriberDomainObject->setUserFullName($subscriber->user_full_name);
                
                if(!$productSubscriberDomainObject->isNull()){
                    $subscriberIterator->add($productSubscriberDomainObject);
                }
            }
            $productDomainObject->swapSubscribersCollection($subscriberIterator);
        }
            
        if($filter["comments"] == "get"){
            $commentIterator  = $this->commentRepository->findAllByProductUuid($productObject->uuid);
            $productDomainObject->swapCommentCollection($commentIterator);
        }
        if($filter["categories"] == "get"){
            $categoryIterator = $this->categoryRepository->findAllByProductUuid($productObject->uuid);
            $productDomainObject->swapCategoryCollection($categoryIterator);   
        }
        if($filter["rates"] == "get"){
            $rateIterator     = $this->rateRepository->findAllByProductUuid($productObject->uuid);
            $productDomainObject->swapRateCollection($rateIterator);
            $productDomainObject->calculateAvarageRate();
        }
        if($filter["images"] == "get"){
            $imageIterator    = $this->imageRepository->findAllByProductUuid($productObject->uuid);
            $productDomainObject->swapImageCollection($imageIterator);
        }
        return $productDomainObject;
    }
    
    function findProductsBySearch($searchValue, $startingLimit, $perPageForProduct, $filter): IteratorAggregate
    {
        $productObjects = $this->productDao->findBySearching($searchValue, $startingLimit, $perPageForProduct);
        return $this->getManyProductDomainModelFromSubEntities($productObjects, $filter);
    }
    
    function deleteProductByUuid(Product $product)
    {
        foreach($product->getComments() as $comment){
            $this->commentRepository->deleteByUuid($comment->getUuid());
        }
        foreach($product->getRates() as  $rate) {
            $this->rateRepository->deleteRateByUuid($rate->getUuid());
        }
        foreach($product->getImages() as $image) {
            $this->imageRepository->deleteByUuid($image->getUuid());
        }
        foreach($product->getSubscribers() as $subscriber){
            $this->productDao->deleteSubscriberByProductUuid($subscriber->getProductUuid());
        }
        foreach($product->getCategories() as $category) {
            $this->categoryRepository->deleteCategoryByProductUuid($category->getProductUuid());
        }
        $this->productDao->deleteByUuid($product->getUuid());
    }
    function updateProductBrandName(Product $p)
    {
        $this->productDao->updateBrandNameByUuid($p);
    }
    function updateProductModelName(Product $p)
    {
        $this->productDao->updateModelNameByUuid($p);
    }
    function updateProductPrice(Product $p)
    {
        $this->productDao->updatePriceByUuid($p);
    }
    function updateProductStockQuantity(Product $p)
    {
        $this->productDao->updateStockQuantityByUuid($p);
    }
    function updateProductHeader(Product $p)
    {
        $this->productDao->updateHeaderByUuid($p);
    }
    function updateProductDescription(Product $p)
    {
        $this->productDao->updateDescriptionByUuid($p);
    }
    function persistImage(Product $p)
    {
        $images = $p->getImages()->getItems();
        foreach($images as $image){
            $this->imageRepository->persist($image);
        }
        
    }
    function deleteProductSubscriberByUserAndProductUuid($userUuid, $productUuid)
    {
        $this->productDao->deleteSubscriberByUserAndProductUuid($userUuid, $productUuid);
    }
    function deleteImageByUuid($uuid)
    {
        $this->imageRepository->deleteByUuid($uuid);
    }
    function createProductCategory(ProductForCreatingCategoryDecorator $c,  $categoryUuidForFinding){
        $categoryCollection = $c->getCategories();
        $category = $categoryCollection->getItem($categoryUuidForFinding);

        $this->categoryRepository->persist($category);
    }
    function findAllProductCategory():ProductInterface{
        $categoryCollection = $this->categoryRepository->findAll();
        $productForCategoryDomainModel = $this->productFactoryContext->executeFactory(
            ProductCategoryCreationalModelFactory::class,
            false
        );
        
        foreach($categoryCollection->getIterator() as $category){
            if($category->isNull()){
                continue;
            }
            $productForCategoryDomainModel->addCategory($category);
        }
        return $productForCategoryDomainModel;
    }
    function findOneProductCategoryByName($categoryName): ProductInterface
    {
        $categoryDomainObject = $this->categoryRepository->findOneByName($categoryName);
        $productForCategoryDomainModel = $this->productFactoryContext->executeFactory(
            ProductCategoryCreationalModelFactory::class,
            true
        );
        $productForCategoryDomainModel->addCategory($categoryDomainObject);
        return $productForCategoryDomainModel;

    }
    function findOneProductCategoryByUuid($uuid):ProductInterface{
        $categoryDomainObject = $this->categoryRepository->findByUuid($uuid);
        $productForCategoryDomainModel = $this->productFactoryContext->executeFactory(
            ProductCategoryCreationalModelFactory::class,
            true
        );
        $productForCategoryDomainModel->addCategory($categoryDomainObject);
        return $productForCategoryDomainModel;
    }
    function findASetOfProductCategoryByUuids($uuids): ProductInterface {
        $categoryDomainObjects = $this->categoryRepository->findASetOfByUuids($uuids);
        $productForCategoryDomainModel = $this->productFactoryContext->executeFactory(
            ProductCategoryCreationalModelFactory::class,
            true
        );
        $productForCategoryDomainModel->swapCategoryCollection($categoryDomainObjects);
        return $productForCategoryDomainModel;
    }
    function updateProductCategoryNameByUuid(Product $c, $categoryUuidForFinding) {
        $category = $c->getCategories()->getItem($categoryUuidForFinding);

        $this->categoryRepository->updateNameByUuid($category);
    }
    function deleteProductCategoryByUuid($uuid)
    {
        $this->categoryRepository->deleteByUuid($uuid);
    }

    function findOneProductWithOnlySubscriberByUuid($uuid, $userUuid): ProductInterface{
        $productObject = $this->productDao->findOneByUuid($uuid);
        $subscriberObj = $this->productDao->findOneOrEmptySubscriberByUuid($uuid, $userUuid);
        $productSubscriberDomainObject = $this->productSubscriberFactory->createInstance(
            false,
            $subscriberObj->uuid,
            $subscriberObj->product_uuid,
            $subscriberObj->user_uuid,
            $subscriberObj->created_at,
            $subscriberObj->updated_at
        );
        $productSubscriberDomainObject->setUserEmail($subscriberObj->email);
        $productSubscriberDomainObject->setUserFullName($subscriberObj->full_name);

        $productDomainObject = $this->productFactoryContext->executeFactory(
            ProductFactory::class,
            false,
            $productObject->uuid,
            $productObject->brand,
            $productObject->model,
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


    
}