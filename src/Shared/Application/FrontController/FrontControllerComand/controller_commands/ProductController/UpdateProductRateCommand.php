<?php

class UpdateProductRateCommand implements Command {
    function __construct(
        private ProductController $productController
    ){}

    function process($params = []){
        $jwtAuth = new JwtAuthMiddleware();
        $jwtAuth->check();
        $this->productController->updateProductRate(...$params);
    }

}