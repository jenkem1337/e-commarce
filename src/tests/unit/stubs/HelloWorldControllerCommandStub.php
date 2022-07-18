<?php
require './vendor/autoload.php';

class HelloWorldCommandStub implements Command{
    private $controller;
    function __construct($controller)
    {
        $this->controller = $controller;
    }
    function process($params = []){
        return $this->controller->helloWorld();
    }
}
class SetNumCommandStub implements Command{
    private $controller;
    function __construct($controller)
    {
        $this->controller = $controller;
    }
    function process($params = []){
        if(isset($params[0]) && isset($params[1])){
            return $this->controller->setNum((int)$params[0],(int)$params[1]);

        }
    }
}

 