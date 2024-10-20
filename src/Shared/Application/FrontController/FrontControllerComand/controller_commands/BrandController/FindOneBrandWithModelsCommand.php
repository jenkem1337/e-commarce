<?php

class FindOneBrandWithModelsCommand implements Command {
    private BrandController $brandController;

    function __construct(BrandController $brandController) {
        $this->brandController = $brandController;
    }

    function process($params = []){
        $this->brandController->findOneBrandWithModels(...$params);
    }

}