<?php
require './vendor/autoload.php';

use PHPUnit\Framework\TestCase;
class FrontControllerTest extends TestCase {
    protected FrontController $frontController;
    function setUp():void{
        $this->frontController = new FrontController();
        

        $this->frontController->registerRoute("GET", "/HelloWorld", new HelloWorldCommandStub(new HelloWorldControllerStub()));
        $this->frontController->registerRoute("GET", "/SetNum/([0-9]+)/([0-9]+)", new SetNumCommandStub(new HelloWorldControllerStub()));
    }

    function test_HelloWorld_Router(){
        $this->assertEquals('{"hello":"world"}', $this->frontController->run("/HelloWorld","GET"));
    }
    function test_Set_Num_Router(){
        $this->assertEquals('{"first":10,"second":20,"sum":30}', $this->frontController->run("/SetNum/10/20","GET"));
    }

    function test_Incorrect_HTTP_Method(){
        try{
            $this->frontController->run("/HelloWorld","POST");
            $this->expectException(Exception::class);
        }catch(Exception $e){
            $this->assertEquals('matched route http method is not equal to actual http method', $e->getMessage());
        }
    }
    function test_Incorrect_Route(){
        try{
           $this->frontController->run("/Hello","GET");
            $this->expectException(Exception::class);
        }catch(Exception $e){
            $this->assertEquals('route doesnt exist', $e->getMessage());
        }

    }

    function test_Request_Uri_NULL(){
        try{
            $this->frontController->run("","PUT");
             $this->expectException(Exception::class);
         }catch(Exception $e){
             $this->assertEquals('request uri must not be null', $e->getMessage());
         }
    }

    function test_HTTP_Method_NULL(){
        try{
            $this->frontController->run("/one-developer-army","");
             $this->expectException(Exception::class);
         }catch(Exception $e){
             $this->assertEquals('http method must not be null', $e->getMessage());
         }

    }

    function test_HelloWorld_Router_With_Query_Param(){
        $this->assertNotNull($this->frontController->run('/HelloWorld?s=12', "GET"));
        
    }
}