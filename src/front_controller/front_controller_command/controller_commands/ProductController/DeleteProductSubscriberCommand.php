<?php


class DeleteProductSubscriberCommand implements Command {
    private ProductController $controller;
    private Middleware $jwtMiddleware;
    function __construct(ProductController $cont, Middleware $middleware)
    {
        $this->controller = $cont;
        $this->jwtMiddleware = $middleware;
    }

    function process($params = [])
    {
            $this->jwtMiddleware->check();
            return $this->controller->deleteProductSubscriber(...$params);
    }
}