<?php
require './vendor/autoload.php';

class ProductRepositoryImpl extends AbstractProductRepositoryMediatorComponent implements ProductRepository{
    private ProductDao $productDao;
    private ProductFactoryContext $productFactoryContext;
	function __construct(
        ProductFactoryContext $productFactoryContext,
        ProductDao $productDao) {
        $this->productFactoryContext = $productFactoryContext;
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
    function findOneProductByUuid($uuid): ProductInterface
    {
        $productObject    = $this->productDao->findOneByUuid($uuid);
        
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
            $productObject->description,
            $productObject->price,
            $productObject->stockquantity
        );
        foreach($commentIterator->getIterator() as $comment){
            $productDomainObject->addComment($comment);
        }
        foreach($categoryIterator->getIterator() as $category){
            $productDomainObject->addCategory($category);
        }
        foreach($rateIterator->getIterator() as $rate){
            $productDomainObject->addRate($rate);
        }
        foreach($imageIterator->getIterator() as $image){
            $productDomainObject->addImage($image);
        }
        return $productDomainObject;
    }
    function persistImage(Product $p)
    {
        $images = $p->getImages()->getItems();
        foreach($images as $image){
            $this->imageRepository->persist($image);
        }
        
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
                break;
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