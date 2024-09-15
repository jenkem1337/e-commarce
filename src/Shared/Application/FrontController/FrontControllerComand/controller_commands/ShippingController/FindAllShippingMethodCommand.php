<?php
class FindAllShippingMethodsCommand implements Command {
    private ShippingController $shippingController;
    private Middleware $jwtMiddleware;
    function __construct(ShippingController $cont, Middleware $middleware)
    {
        $this->shippingController = $cont;
        $this->jwtMiddleware = $middleware;
    }
    function process($params = [])
    {
        $this->jwtMiddleware->check();
        $this->shippingController->findAllShippingMethods();
    }
}