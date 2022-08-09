<<?php
require './vendor/autoload.php';

class DeleteImageCommand implements Command {
    private ImageController $controller;
    private Middleware $jwtMiddleware;
    function __construct(ImageController $cont, Middleware $middleware)
    {
        $this->controller = $cont;
        $this->jwtMiddleware = $middleware;
    }

    function process($params = [])
    {
            $this->jwtMiddleware->linkWith(new IsAdminMiddleware());
            $this->jwtMiddleware->check();
            return $this->controller->deleteImageByUuid($params[0], $params[1]);
    }

}