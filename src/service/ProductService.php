<?php

interface ProductService {
    //product
    function craeteNewProduct(ProductCreationalDto $dto):ResponseViewModel;
    function deleteProduct(DeleteProductByUuidDto $dto): ResponseViewModel;
    function findAllProduct(FindAllProductsDto $dto):ResponseViewModel;
    function findAllProductWithPagination(FindAllProductWithPaginationDto $dto): ResponseViewModel;
    function findOneProductByUuid(FindOneProductByUuidDto $dto): ResponseViewModel;
    function updateProductBrandName(ChangeProductBrandNameDto $dto): ResponseViewModel;
    function updateProductModelName(ChangeProductModelNameDto $dto): ResponseViewModel;
    function updateProductHeader(ChangeProductHeaderDto $dto): ResponseViewModel;
    function updateProductDescription(ChangeProductDescriptionDto $dto): ResponseViewModel;
    function updateProductPrice(ChangeProductPriceDto $dto): ResponseViewModel;
}