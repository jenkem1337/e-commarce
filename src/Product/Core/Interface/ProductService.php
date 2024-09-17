<?php

interface ProductService {
    //product
    function craeteNewProduct(ProductCreationalDto $dto):ResponseViewModel;
    function createNewProductSubscriber(ProductSubscriberCreationalDto $dto): ResponseViewModel;
    function deleteProduct(DeleteProductByUuidDto $dto): ResponseViewModel;
    function deleteProductSubscriber(DeleteProductSubscriberDto $dto): ResponseViewModel;
    function findAllProduct(FindAllProductsDto $dto):ResponseViewModel;
    function findProductsByPriceRange(FindProductsByPriceRangeDto $dto): ResponseViewModel;
    function findProductsBySearch(FindProductsBySearchDto $dto): ResponseViewModel;
    function findAllProductWithPagination(FindAllProductWithPaginationDto $dto): ResponseViewModel;
    function findOneProductByUuid(FindOneProductByUuidDto $dto): ResponseViewModel;
    function updateProductDetailsByUuid(ProductDetailDto $dto):ResponseViewModel;
    function updateProductStockQuantity(ChangeProductStockQuantityDto $dto):ResponseViewModel;
}