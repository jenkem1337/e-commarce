<?php
require './vendor/autoload.php';
class HelloWorldControllerStub {
    public array $arr = [];
    
    function helloWorld(){
        return json_encode(["hello"=>"world"]);
    }
    function setNum(int $first,int $second){
        return json_encode([
            "first"=>$first,
            "second"=>$second,
            "sum"=>$first+$second
        ]);
    }

}
