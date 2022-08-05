<?php
require './vendor/autoload.php';

class ProductRepositoryImpl extends AbstractProductRepositoryMediatorComponent implements ProductRepository{
    private ProductFactoryContext $productFactoryContext;
	function __construct(
        ProductFactoryContext $productFactoryContext) {
        $this->productFactoryContext = $productFactoryContext;
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