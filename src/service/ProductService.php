<?php

interface ProductService {
    function createNewCategory(CategoryCreationalDto $dto):ResponseViewModel;
    function findOneCategoryByUuid(FindCategoryByUuidDto $dto):ResponseViewModel;
    function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto):ResponseViewModel;
    function findAllCategory(FindAllCategoryDto $dto):ResponseViewModel;
}