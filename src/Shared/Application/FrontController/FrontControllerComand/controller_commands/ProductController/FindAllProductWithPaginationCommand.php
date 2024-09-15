<?php


class FindAllProductWithPaginationCommand implements Command {
    private ProductController $controller;
    function __construct(ProductController $cont)
    {
        $this->controller = $cont;
    }

    function process($params = [])
    {
        return $this->controller->findAllProductWithPagination();
    }
}

