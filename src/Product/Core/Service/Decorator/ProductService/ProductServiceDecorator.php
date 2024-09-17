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
	function findAllProduct(FindAllProductsDto $dto): ResponseViewModel
	{
		return $this->productService->findAllProduct($dto);
	}
	function findAllProductWithPagination(FindAllProductWithPaginationDto $dto): ResponseViewModel
	{
		return $this->productService->findAllProductWithPagination($dto);
	}
	function findProductsBySearch(FindProductsBySearchDto $dto): ResponseViewModel
	{
		return $this->productService->findProductsBySearch($dto);
	}
	function findProductsByPriceRange(FindProductsByPriceRangeDto $dto): ResponseViewModel
	{
		return $this->productService->findProductsByPriceRange($dto);
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
}