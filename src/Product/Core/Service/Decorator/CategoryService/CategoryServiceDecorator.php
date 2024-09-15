<?php

abstract class CategoryServiceDecorator implements CategoryService {
    private CategoryService $categoryService;
    function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    function createNewCategory(CategoryCreationalDto $dto): ResponseViewModel {
        return $this->categoryService->createNewCategory($dto);
	}
	
	/**
	 *
	 * @param FindCategoryByUuidDto $dto
	 *
	 * @return ResponseViewModel
	 */
	function findOneCategoryByUuid(FindCategoryByUuidDto $dto): ResponseViewModel {
        return $this->categoryService->findOneCategoryByUuid($dto);
	}
	
	/**
	 *
	 * @param UpdateCategoryNameByUuidDto $dto
	 *
	 * @return ResponseViewModel
	 */
	function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto): ResponseViewModel {
        return $this->categoryService->updateCategoryNameByUuid($dto);
	}
	
	/**
	 *
	 * @param FindAllCategoryDto $dto
	 *
	 * @return ResponseViewModel
	 */
	function findAllCategory(FindAllCategoryDto $dto): ResponseViewModel {
        return $this->categoryService->findAllCategory($dto);
	}
	
	/**
	 *
	 * @param DeleteCategoryDto $dto
	 *
	 * @return ResponseViewModel
	 */
	function deleteCategoryByUuid(DeleteCategoryDto $dto): ResponseViewModel {
        return $this->categoryService->deleteCategoryByUuid($dto);
	}

}