<?php

class FindOneCategoryCommand implements Command {
    private CategoryController $controller;
    private Middleware $jwtMiddleware;
    function __construct(CategoryController $cont, Middleware $middleware)
    {
        $this->controller = $cont;
        $this->jwtMiddleware = $middleware;
    }

    function process($params = [])
    {
            $this->jwtMiddleware->linkWith(new IsAdminMiddleware());
            $this->jwtMiddleware->check();
            return $this->controller->findOneCategoryByUuid($params[0]);
    }

}