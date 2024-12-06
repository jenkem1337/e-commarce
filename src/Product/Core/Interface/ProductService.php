<?php

interface ProductService {
    //product
    function craeteNewProduct(ProductCreationalDto $dto):ResponseViewModel;
    function createNewProductSubscriber(ProductSubscriberCreationalDto $dto): ResponseViewModel;
    function deleteProduct(DeleteProductByUuidDto $dto): ResponseViewModel;
    function deleteProductSubscriber(DeleteProductSubscriberDto $dto): ResponseViewModel;
    function findProductsByCriteria(FindProductsByCriteriaDto $dto):ResponseViewModel;
    function findProductsBySearch(FindProductsBySearchDto $dto): ResponseViewModel;
    function findOneProductByUuid(FindOneProductByUuidDto $dto): ResponseViewModel;
    function updateProductDetailsByUuid(ProductDetailDto $dto):ResponseViewModel;
    function updateProductStockQuantity(ChangeProductStockQuantityDto $dto):ResponseViewModel;
    function checkQuantityAndDecrease(CheckAndDecreaseProductsDto $dto):ResponseViewModel;
    function incrementStockQuantityForCanceledOrder($dto): ResponseViewModel;
}