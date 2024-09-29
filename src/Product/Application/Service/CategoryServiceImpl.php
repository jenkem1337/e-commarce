<?php

class CategoryServiceImpl implements CategoryService {
    private CategoryRepository $categoryRepository;
	function __construct(CategoryRepository $categoryRepository) {
	    $this->categoryRepository = $categoryRepository;
	}
    function createNewCategory(CategoryCreationalDto $dto): ResponseViewModel
    {
        $categoryDomainObject = Category::newInstanceWithInsertLog(
            $dto->getUuid(),
            $dto->getCategoryName(),
            $dto->getCreatedAt(),
            $dto->getUpdatedAt()
        );

        
        $this->categoryRepository->saveChanges($categoryDomainObject);
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
        $category = $this->categoryRepository->findByUuid($dto->getUuid());
                                            
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
        $categoryCollection = $this->categoryRepository->findAll();
        return new SuccessResponse([
            "data" => $categoryCollection
            ]
        );
    }
    function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto): ResponseViewModel
    {
        $category = $this->categoryRepository->findByUuid($dto->getUuid());
        
        if($category->isNull()){
            throw new DoesNotExistException('category');
        }
        $category->changeCategoryName($dto->getNewCategoryName());

        $this->categoryRepository->saveChanges($$category);
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
        $category = $this->categoryRepository->findByUuid($dto->getUuid());
        if($category->isNull()){
            throw new DoesNotExistException('category');
        }
        $this->categoryRepository->deleteByUuid($dto->getUuid());
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