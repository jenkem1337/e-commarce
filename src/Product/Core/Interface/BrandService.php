<?php

interface BrandService {
    function createBrand(CreationalBrandDto $creationalBrandDto):ResponseViewModel;
    function createBrandModel(CreateBrandModelDto $createBrandModelDto):ResponseViewModel;
    function changeBrandName(ChangeBrandNameDto $changeBrandNameDto):ResponseViewModel;
    function changeBrandModelName(ChangeBrandModelNameDto $changeBrandModelNameDto): ResponseViewModel;
    function deleteBrand(DeleteBrandDto $deleteBrandDto): ResponseViewModel;
    function findOneBrandWithModels(FindOneBrandWithModelsDto $findOneBrandWithModelsDto):ResponseViewModel;
    function findAll():ResponseViewModel;
}