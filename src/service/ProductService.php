<?php

interface ProductService {
    //product
    function craeteNewProduct(ProductCreationalDto $dto):ResponseViewModel;
    function findOneProductByUuid(FindOneProductByUuidDto $dto): ResponseViewModel;
    function updateProductBrandName(ChangeProductBrandNameDto $dto): ResponseViewModel;
    function updateProductModelName(ChangeProductModelNameDto $dto): ResponseViewModel;
    function updateProductHeader(ChangeProductHeaderDto $dto): ResponseViewModel;
    function updateProductDescription(ChangeProductDescriptionDto $dto): ResponseViewModel;
}