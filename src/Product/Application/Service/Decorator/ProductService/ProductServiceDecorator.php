<?php

abstract class ProductServiceDecorator implements ProductService {

    private ProductService $productService;
	function __construct(ProductService $productService) {
        $this->productService = $productService;
	}
	function craeteNewProduct(ProductCreationalDto $dto): ResponseViewModel
	{
		return $this->productService->craeteNewProduct($dto);
	}
	function findProductsByCriteria(FindProductsByCriteriaDto $dto): ResponseViewModel
	{
		return $this->productService->findProductsByCriteria($dto);
	}
	function findProductsBySearch(FindProductsBySearchDto $dto): ResponseViewModel
	{
		return $this->productService->findProductsBySearch($dto);
	}
	function findOneProductByUuid(FindOneProductByUuidDto $dto): ResponseViewModel {
		return $this->productService->findOneProductByUuid($dto);
	}
	function createNewProductSubscriber(ProductSubscriberCreationalDto $dto): ResponseViewModel
	{
		return $this->productService->createNewProductSubscriber($dto);
	}
	function updateProductStockQuantity(ChangeProductStockQuantityDto $dto): ResponseViewModel
	{
		return $this->productService->updateProductStockQuantity($dto);
	}
	function updateProductDetailsByUuid(ProductDetailDto $dto): ResponseViewModel{
		return $this->productService->updateProductDetailsByUuid($dto);
	}
		function deleteProduct(DeleteProductByUuidDto $dto): ResponseViewModel
	{
		return $this->productService->deleteProduct($dto);
	}
	function deleteProductSubscriber(DeleteProductSubscriberDto $dto): ResponseViewModel
	{
		return $this->productService->deleteProductSubscriber($dto);
	}
	function checkQuantityAndDecrease(CheckAndDecreaseProductsDto $dto): ResponseViewModel {
		return $this->productService->checkQuantityAndDecrease($dto);
	}
}