<?php

class ProductRepositoryImpl extends AbstractProductRepositoryMediatorComponent implements ProductRepository{
    private ProductDao $productDao;
    private ProductFactoryContext $productFactoryContext;
	function __construct(
        ProductFactoryContext $productFactoryContext,
        ProductDao $productDao) {
        $this->productFactoryContext = $productFactoryContext;
        $this->productDao = $productDao;
        
	}
    function saveChanges($e){
        $this->productDao->saveChanges($e);
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
                $subscriberCollection = $this->productSubscriberRepository->findAllProductSubscriberByProductUuid($productObject->uuid);
                $productDomainObject->swapSubscribersCollection($subscriberCollection);
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
    function findProductsByCriteria($filter): IteratorAggregate
    {
        $productObjects = $this->productDao->findProductsByCriteria();
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

        
        if($filter["subscribers"] == "get"){
            $subscriberCollection = $this->productSubscriberRepository->findAllProductSubscriberByProductUuid($productObject->uuid);
            $productDomainObject->swapSubscribersCollection($subscriberCollection);
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
        $this->commentRepository->deleteAllByProductUuid($product->getUuid());
        $this->rateRepository->deleteAllByProductUuid($product->getUuid());
        $this->imageRepository->deleteAllByProductUuid($product->getUuid());
        $this->productSubscriberRepository->deleteByProductUuid($product->getUuid());
        $this->categoryRepository->deleteCategoryByProductUuid($product->getUuid());
        
        $this->productDao->deleteByUuid($product->getUuid());
    }
    
    function persistImage(Product $p)
    {
        $images = $p->getImages()->getItems();
        foreach($images as $image){
            $this->imageRepository->persist($image);
        }
        
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
        $productForCategoryDomainModel->swapCategoryCollection($categoryCollection);
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
        $productSubscriberDomainObject = $this->productSubscriberRepository->findOneOrEmptySubscriberByUuid($productObject->uuid, $userUuid);
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