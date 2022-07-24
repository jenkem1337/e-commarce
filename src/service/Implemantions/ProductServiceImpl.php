<?php
require './vendor/autoload.php';
class ProductServiceImpl implements ProductService {
    private ProductRepository $productRepository;
    private ProductFactoryContext $productFactoryContext;
    private CategoryFactory $categoryFactory;
	function __construct(
        ProductRepository $productRepository,
        ProductFactoryContext $productFactoryContext,
        Factory $categoryFactory
    ) {
	    $this->productRepository     = $productRepository;
        $this->productFactoryContext = $productFactoryContext;
        $this->categoryFactory       = $categoryFactory; 

	}
    function createNewCategory(CategoryCreationalDto $dto): ResponseViewModel
    {
        $productForCategoryDomainObject = $this->productFactoryContext->executeFactory(
            ProductCategoryCreationalModelFactory::class,
            true
        );
        $categoryDomainObject = $this->categoryFactory->createInstance(
            true,
            $dto->getUuid(),
            $dto->getCategoryName(),
            $dto->getCreatedAt(),
            $dto->getUpdatedAt()
        );
        $isCategoryExist = $this->productRepository->findOneCategoryByUuid($dto->getUuid());
        if( !($isCategoryExist->isNull()) ){
            throw new AlreadyExistException('category');
        }
        $productForCategoryDomainObject->addCategory($categoryDomainObject);
        $this->productRepository->createCategory($productForCategoryDomainObject);
        return new CategoryCreatedResponseDto(
            $dto->getUuid(),
            $dto->getCategoryName(),
            $dto->getCreatedAt(),
            $dto->getUpdatedAt()
        );
    }
    function findOneCategoryByUuid(FindCategoryByUuidDto $dto): ResponseViewModel
    {
        $productForCategoryDomainObject = $this->productRepository->findOneCategoryByUuid($dto->getUuid());
        if($productForCategoryDomainObject->isNull()){
            throw new NotFoundException('category');
        }
        $category = $productForCategoryDomainObject->getCategories()
                                                   ->getItem($dto->getUuid());
        return new OneCategoryFoundedResponseDto(
            $category->getUuid(),
            $category->getCategoryName(),
            $category->getCreatedAt(),
            $category->getUpdatedAt()
        );
    }
    function findAllCategory(FindAllCategoryDto $dto): ResponseViewModel
    {
        $productForCategoryDomainObject = $this->productRepository->findAllCategory();
        $categoryCollection = $productForCategoryDomainObject->getCategories();
        return new AllCategoryResponseDto($categoryCollection->getIterator());
    }
    function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto): ResponseViewModel
    {
        $productForCategoryDomainObject = $this->productRepository->findOneCategoryByUuid($dto->getUuid());
        if($productForCategoryDomainObject->isNull()){
            throw new NotFoundException('category');
        }
        $category = $productForCategoryDomainObject->getCategories()
                                                ->getItem($dto->getUuid());
        
        $category->changeCategoryName($dto->getNewCategoryName());

        $productForCategoryDomainObject->addCategory($category);

        $this->productRepository->updateCategoryNameByUuid($productForCategoryDomainObject);
        return new CategoryNameChangedResponseDto('Category name changed successfuly');
    }
}