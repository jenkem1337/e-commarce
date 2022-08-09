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
	function updateProductBrandName(ChangeProductBrandNameDto $dto): ResponseViewModel{
		return $this->productService->updateProductBrandName($dto);
	}
	function findOneProductByUuid(FindOneProductByUuidDto $dto): ResponseViewModel
	{
		return $this->productService->findOneProductByUuid($dto);
	}
}