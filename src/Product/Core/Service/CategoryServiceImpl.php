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

        $productForCategoryDomainObject->addCategory($categoryDomainObject);
        
        $this->productAggregateRepository->createProductCategory($productForCategoryDomainObject, $categoryDomainObject->getUuid());
        return new SuccessResponse([
            "message" => "Category created",
            "data" => [
                    "uuid" => $dto->getUuid(),
                    "category_name" => $dto->getCategoryName(),
                    "created_at" => $dto->getCreatedAt(),
                    "updated_at" => $dto->getUpdatedAt()

                ]
            ]);
    }
    function findOneCategoryByUuid(FindCategoryByUuidDto $dto): ResponseViewModel
    {
        $category = $this->productAggregateRepository->findOneProductCategoryByUuid($dto->getUuid())
                                            ->getCategories()
                                            ->getItem($dto->getUuid());
        if($category->isNull()){
            throw new NotFoundException('category');
        }
        return new SuccessResponse([
            "message" => "A category founded",
            "data" => [
                    "uuid" => $dto->getUuid(),
                    "category_name" => $category->getCategoryName(),
                    "created_at" => $category->getCreatedAt(),
                    "updated_at" => $category->getUpdatedAt()

                ]
            ]);
    }
    function findAllCategory(FindAllCategoryDto $dto): ResponseViewModel
    {
        $categoryCollection = $this->productAggregateRepository->findAllProductCategory();
        return new SuccessResponse([
            "data" => $categoryCollection
            ]
        );
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
        return new SuccessResponse([
            "message" => "Category name updated successfully",
            "data" => [
                    "uuid" => $dto->getUuid(),
                    "category_name" => $category->getCategoryName(),
                    "updated_at" => $category->getUpdatedAt()
                ]
            ]);
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
        return new SuccessResponse([
            "message" => "Category deleted successfully",
            "data" => [
                    "uuid" => $dto->getUuid(),
                    "category_name" => $category->getCategoryName(),
                    "updated_at" => $category->getUpdatedAt()
                ]
            ]);

    }

}