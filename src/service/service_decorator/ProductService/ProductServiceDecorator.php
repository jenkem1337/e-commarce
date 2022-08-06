<?php
require './vendor/autoload.php';

abstract class ProductServiceDecorator implements ProductService {

    private ProductService $productService;
	function __construct(ProductService $productService) {
        $this->productService = $productService;
	}
	function craeteNewProduct(ProductCreationalDto $dto): ResponseViewModel
	{
		return $this->productService->craeteNewProduct($dto);
	}
	function uploadImageForProduct(ImageCreationalDto $dto): ResponseViewModel
	{
		return $this->productService->uploadImageForProduct($dto);
	}
	/**
	 *
	 * @param CategoryCreationalDto $dto
	 *
	 * @return ResponseViewModel
	 */
	function createNewCategory(CategoryCreationalDto $dto): ResponseViewModel {
        return $this->productService->createNewCategory($dto);
	}
	
	/**
	 *
	 * @param FindCategoryByUuidDto $dto
	 *
	 * @return ResponseViewModel
	 */
	function findOneCategoryByUuid(FindCategoryByUuidDto $dto): ResponseViewModel {
        return $this->productService->findOneCategoryByUuid($dto);
	}
	
	/**
	 *
	 * @param UpdateCategoryNameByUuidDto $dto
	 *
	 * @return ResponseViewModel
	 */
	function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto): ResponseViewModel {
        return $this->productService->updateCategoryNameByUuid($dto);
	}
	
	/**
	 *
	 * @param FindAllCategoryDto $dto
	 *
	 * @return ResponseViewModel
	 */
	function findAllCategory(FindAllCategoryDto $dto): ResponseViewModel {
        return $this->productService->findAllCategory($dto);
	}
	
	/**
	 *
	 * @param DeleteCategoryDto $dto
	 *
	 * @return ResponseViewModel
	 */
	function deleteCategoryByUuid(DeleteCategoryDto $dto): ResponseViewModel {
        return $this->productService->deleteCategoryByUuid($dto);
	}
}