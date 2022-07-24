<?php
require './vendor/autoload.php';

class ProductRepositoryImpl implements ProductRepository {
    private CategoryRepository $categoryRepository;
    private ProductFactoryContext $productFactoryContext;
	function __construct(
        CategoryRepository $categoryRepository,
        ProductFactoryContext $productFactoryContext) {
        $this->categoryRepository = $categoryRepository;
        $this->productFactoryContext = $productFactoryContext;
	}
    function createCategory(ProductForCreatingCategoryDecorator $c){
        $categoryCollection = $c->getCategories();
        $categories = $categoryCollection->getItems();
        $category = $categories[count($categories) - 1];

        $this->categoryRepository->persist($category);
    }
    function findAllCategory():ProductInterface{
        $categoryCollection = $this->categoryRepository->findAll();
        $productForCategoryDomainModel = $this->productFactoryContext->executeFactory(
            ProductCategoryCreationalModelFactory::class,
            false
        );
        foreach($categoryCollection->getIterator() as $category){
            $productForCategoryDomainModel->addCategory($category);
        }
        return $productForCategoryDomainModel;
    }
    function findOneCategoryByUuid($uuid):ProductInterface{
        $categoryDomainObject = $this->categoryRepository->findByUuid($uuid);
        $productForCategoryDomainModel = $this->productFactoryContext->executeFactory(
            ProductCategoryCreationalModelFactory::class,
            false
        );
        $productForCategoryDomainModel->addCategory($categoryDomainObject);
        return $productForCategoryDomainModel;
    }
    function updateCategoryNameByUuid(ProductInterface $c) {
        $category = $c->getCategories()->getItems()[0];

        $this->categoryRepository->updateNameByUuid($category);
    }

}