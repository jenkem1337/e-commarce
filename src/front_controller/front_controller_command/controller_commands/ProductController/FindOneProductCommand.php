<?php


class FindOneProductCommand implements Command {
    private ProductController $controller;
    function __construct(ProductController $cont)
    {
        $this->controller = $cont;
    }

    function process($params = [])
    {
            return $this->controller->findOneProductByUuid($params[0]);
    }
}

