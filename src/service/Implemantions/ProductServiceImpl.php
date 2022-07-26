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
        $categories = $this->productRepository->findOneCategoryByName($dto->getCategoryName())
                                            ->getCategories();

        foreach($categories->getIterator() as $category){
            if($category->getCategoryName() == $dto->getCategoryName()){
                 if(!($category->isNull())){
                    throw new AlreadyExistException('category');
                }
            }
        }

        $productForCategoryDomainObject->addCategory($categoryDomainObject);
        
        $this->productRepository->createCategory($productForCategoryDomainObject, $categoryDomainObject->getUuid());
        return new CategoryCreatedResponseDto(
            $dto->getUuid(),
            $dto->getCategoryName(),
            $dto->getCreatedAt(),
            $dto->getUpdatedAt()
        );
    }
    function findOneCategoryByUuid(FindCategoryByUuidDto $dto): ResponseViewModel
    {
        $category = $this->productRepository->findOneCategoryByUuid($dto->getUuid())
                                            ->getCategories()
                                            ->getItem($dto->getUuid());
        if($category->isNull()){
            throw new DoesNotExistException('category');
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
        $productForCategoryDomainObject = $this->productRepository->findAllCategory();
        $categoryCollection = $productForCategoryDomainObject->getCategories();
        return new AllCategoryResponseDto($categoryCollection->getIterator());
    }
    function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto): ResponseViewModel
    {
        $productForCategoryDomainObject = $this->productRepository->findOneCategoryByUuid($dto->getUuid());
        $category = $productForCategoryDomainObject->getCategories()
                                                ->getItem($dto->getUuid());
        if($category->isNull()){
            throw new DoesNotExistException('category');
        }
        $category->changeCategoryName($dto->getNewCategoryName());

        $productForCategoryDomainObject->addCategory($category);

        $this->productRepository->updateCategoryNameByUuid($productForCategoryDomainObject ,$dto->getUuid());
        return new CategoryNameChangedResponseDto('Category name changed successfuly');
    }
    function deleteCategoryByUuid(DeleteCategoryDto $dto): ResponseViewModel
    {
        $category = $this->productRepository->findOneCategoryByUuid($dto->getUuid())
                                            ->getCategories()
                                            ->getItem($dto->getUuid());
        if($category->isNull()){
            throw new DoesNotExistException('category');
        }
        $this->productRepository->deleteCategoryByUuid($dto->getUuid());
        return new CategoryDeletedResponseDto('Category deleted successfuly');

    }
}