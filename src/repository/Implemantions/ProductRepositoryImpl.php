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
    function createProduct(Product $p)
    {
        $categories = $p->getCategories()->getItems();
        $this->productDao->persist($p);
        foreach($categories as $category){
            $this->categoryRepository->addCategoryUuidToProduct($category);
        }
    }
    function findAllProducts(): IteratorAggregate
    {
        $productCollection = new ProductCollection();

        $productObjects = $this->productDao->findAll();
        foreach($productObjects as $productObject){       
            $productSubscriberObjects = $this->productDao->findAllProductSubscriberByProductUuid($productObject->uuid);
            $subscriberIterator = new SubscriberCollection();

            foreach($productSubscriberObjects as $subscriber){
                $userDomainObject = $this->userRepository->findOneUserByUuid($subscriber->user_uuid);
                $productSubscriberDomainObject = $this->productSubscriberFactory->createInstance(
                    false,
                    $subscriber->uuid,
                    $subscriber->product_uuid,
                    $subscriber->user_uuid,
                    $subscriber->created_at,
                    $subscriber->updated_at
                );

                $productSubscriberDomainObject->setUserEmail($userDomainObject->getEmail());
                $productSubscriberDomainObject->setUserFullName($userDomainObject->getFullname());
                $subscriberIterator->add($productSubscriberDomainObject);
            }


            $commentIterator  = $this->commentRepository->findAllByProductUuid($productObject->uuid);
            $categoryIterator = $this->categoryRepository->findAllByProductUuid($productObject->uuid);
            $rateIterator     = $this->rateRepository->findAllByProductUuid($productObject->uuid);
            $imageIterator    = $this->imageRepository->findAllByProductUuid($productObject->uuid);
           
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
            foreach($subscriberIterator->getIterator() as $subscriber){
                if($subscriber->isNull()) continue;
                $productDomainObject->addSubscriber($subscriber);
            }
            foreach($commentIterator->getIterator() as $comment){
                if($comment->isNull()) continue;
                $productDomainObject->addComment($comment);
            }
            foreach($categoryIterator->getIterator() as $category){
                if($category->isNull()) continue;
                $productDomainObject->addCategory($category);
            }
            foreach($rateIterator->getIterator() as $rate){
                if($rate->isNull()) continue;
                $productDomainObject->addRate($rate);
            }
            foreach($imageIterator->getIterator() as $image){
                if($image->isNull()) continue;
                $productDomainObject->addImage($image);
            }
            $productCollection->add($productDomainObject);
        }
        return $productCollection;
    }
    function findOneProductByUuid($uuid): ProductInterface
    {
        $productObject    = $this->productDao->findOneByUuid($uuid);
        $productSubscriberObjects = $this->productDao->findAllProductSubscriberByProductUuid($uuid);
        $subscriberIterator = new SubscriberCollection();

        foreach($productSubscriberObjects as $subscriber){
            $userDomainObject = $this->userRepository->findOneUserByUuid($subscriber->user_uuid);
            $productSubscriberDomainObject = $this->productSubscriberFactory->createInstance(
                false,
                $subscriber->uuid,
                $subscriber->product_uuid,
                $subscriber->user_uuid,
                $subscriber->created_at,
                $subscriber->updated_at
            );
            $productSubscriberDomainObject->setUserEmail($userDomainObject->getEmail());
            $productSubscriberDomainObject->setUserFullName($userDomainObject->getFullname());
            $subscriberIterator->add($productSubscriberDomainObject);
        }

        $commentIterator  = $this->commentRepository->findAllByProductUuid($uuid);
        $categoryIterator = $this->categoryRepository->findAllByProductUuid($uuid);
        $rateIterator     = $this->rateRepository->findAllByProductUuid($uuid);
        $imageIterator    = $this->imageRepository->findAllByProductUuid($uuid);

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
        foreach($subscriberIterator->getIterator() as $subscriber){
            if($subscriber->isNull()) continue;
            $productDomainObject->addSubscriber($subscriber);
        }
        foreach($commentIterator->getIterator() as $comment){
            if($comment->isNull()) continue;
            $productDomainObject->addComment($comment);
        }
        foreach($categoryIterator->getIterator() as $category){
            if($category->isNull()) continue;
            $productDomainObject->addCategory($category);
        }
        foreach($rateIterator->getIterator() as $rate){
            if($rate->isNull()) continue;
            $productDomainObject->addRate($rate);
        }
        foreach($imageIterator->getIterator() as $image){
            if($image->isNull()) continue;
            $productDomainObject->addImage($image);
        }
        return $productDomainObject;
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
    function deleteImageByUuid($uuid)
    {
        $this->imageRepository->deleteByUuid($uuid);
    }
    function createCategory(ProductForCreatingCategoryDecorator $c,  $categoryUuidForFinding){
        $categoryCollection = $c->getCategories();
        $category = $categoryCollection->getItem($categoryUuidForFinding);

        $this->categoryRepository->persist($category);
    }
    function findAllCategory():ProductInterface{
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
    function findOneCategoryByName($categoryName): ProductInterface
    {
        $categoryDomainObject = $this->categoryRepository->findOneByName($categoryName);
        $productForCategoryDomainModel = $this->productFactoryContext->executeFactory(
            ProductCategoryCreationalModelFactory::class,
            true
        );
        $productForCategoryDomainModel->addCategory($categoryDomainObject);
        return $productForCategoryDomainModel;

    }
    function findOneCategoryByUuid($uuid):ProductInterface{
        $categoryDomainObject = $this->categoryRepository->findByUuid($uuid);
        $productForCategoryDomainModel = $this->productFactoryContext->executeFactory(
            ProductCategoryCreationalModelFactory::class,
            true
        );
        $productForCategoryDomainModel->addCategory($categoryDomainObject);
        return $productForCategoryDomainModel;
    }
    function updateCategoryNameByUuid(Product $c, $categoryUuidForFinding) {
        $category = $c->getCategories()->getItem($categoryUuidForFinding);

        $this->categoryRepository->updateNameByUuid($category);
    }
    function deleteCategoryByUuid($uuid)
    {
        $this->categoryRepository->deleteByUuid($uuid);
    }

}