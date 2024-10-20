<?php

class ChangeBrandModelNameCommand implements Command {
    private BrandController $brandController;

    function __construct(BrandController $brandController) {
        $this->brandController = $brandController;
    }

    function process($params = []){
        $jwtMiddleware = new JwtAuthMiddleware();
        $jwtMiddleware->linkWith(new IsAdminMiddleware());
        $jwtMiddleware->check();
        $this->brandController->changeBrandModelName(...$params);
    }

}