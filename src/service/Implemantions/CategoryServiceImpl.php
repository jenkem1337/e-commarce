<?php

class CategoryServiceImpl implements CategoryService {
    private ProductRepository $productAggregateRepository;
    private CategoryFactory $categoryFactory;
    private ProductFactoryContext $productAggregateFactoryContext;
	function __construct(ProductRepository $productAggregateRepository, CategoryFactory $categoryFactory, ProductFactoryContext $productAggregateFactoryContext) {
	    $this->productAggregateRepository = $productAggregateRepository;
	    $this->categoryFactory = $categoryFactory;
	    $this->productAggregateFactoryContext = $productAggregateFactoryContext;
	}
    function createNewCategory(CategoryCreationalDto $dto): ResponseViewModel
    {
        $productForCategoryDomainObject = $this->productAggregateFactoryContext->executeFactory(
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
        $categories = $this->productAggregateRepository->findOneProductCategoryByName($dto->getCategoryName())
                                            ->getCategories();
        /*foreach($categories->getIterator() as $category){
            if($category->getCategoryName() == $dto->getCategoryName()){
                 if(!($category->isNull())){
                    throw new AlreadyExistException('category');
                }
            }
        }*/

        $productForCategoryDomainObject->addCategory($categoryDomainObject);
        
        $this->productAggregateRepository->createProductCategory($productForCategoryDomainObject, $categoryDomainObject->getUuid());
        return new CategoryCreatedResponseDto(
            $dto->getUuid(),
            $dto->getCategoryName(),
            $dto->getCreatedAt(),
            $dto->getUpdatedAt()
        );
    }
    function findOneCategoryByUuid(FindCategoryByUuidDto $dto): ResponseViewModel
    {
        $category = $this->productAggregateRepository->findOneProductCategoryByUuid($dto->getUuid())
                                            ->getCategories()
                                            ->getItem($dto->getUuid());
        if($category->isNull()){
            throw new NotFoundException('category');
        }
        return new OneCategoryFoundedResponseDto(
            $category->getUuid(),
            $category->getCategoryName(),
            $category->getCreatedAt(),
            $category->getUpdatedAt()
        );
    }
    function findAllCategory(FindAllCategoryDto $dto): ResponseViewModel
    {
        $productForCategoryDomainObject = $this->productAggregateRepository->findAllProductCategory();
        $categoryCollection = $productForCategoryDomainObject->getCategories();
        return new AllCategoryResponseDto($categoryCollection->getIterator());
    }
    function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto): ResponseViewModel
    {
        $productForCategoryDomainObject = $this->productAggregateRepository->findOneProductCategoryByUuid($dto->getUuid());
        $category = $productForCategoryDomainObject->getCategories()
                                                ->getItem($dto->getUuid());
        if($category->isNull()){
            throw new DoesNotExistException('category');
        }
        $category->changeCategoryName($dto->getNewCategoryName());

        $productForCategoryDomainObject->addCategory($category);

        $this->productAggregateRepository->updateProductCategoryNameByUuid($productForCategoryDomainObject ,$dto->getUuid());
        return new CategoryNameChangedResponseDto('Category name changed successfuly');
    }
    function deleteCategoryByUuid(DeleteCategoryDto $dto): ResponseViewModel
    {
        $category = $this->productAggregateRepository->findOneProductCategoryByUuid($dto->getUuid())
                                            ->getCategories()
                                            ->getItem($dto->getUuid());
        if($category->isNull()){
            throw new DoesNotExistException('category');
        }
        $this->productAggregateRepository->deleteProductCategoryByUuid($dto->getUuid());
        return new CategoryDeletedResponseDto('Category deleted successfuly');

    }

}