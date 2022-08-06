<?php

interface ProductService {
    function craeteNewProduct(ProductCreationalDto $dto):ResponseViewModel;
    function uploadImageForProduct(ImageCreationalDto $dto): ResponseViewModel;
    function createNewCategory(CategoryCreationalDto $dto):ResponseViewModel;
    function findOneCategoryByUuid(FindCategoryByUuidDto $dto):ResponseViewModel;
    function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto):ResponseViewModel;
    function findAllCategory(FindAllCategoryDto $dto):ResponseViewModel;
    function deleteCategoryByUuid(DeleteCategoryDto $dto): ResponseViewModel;
}