<?php

class FrontController {  
    
    private array $routes = [];
    function setExceptionHandler($ExceptionHandler, string $methodName){
        error_reporting(0);
        set_exception_handler([$ExceptionHandler, $methodName]);
    }
    function registerRoute(string $requestMethod,string $pattern, Command $cmd){
        
        $this->routes[] = ['req_method' => $requestMethod,'pattern' => $pattern, 'command' => $cmd];
    }

    function run($requsetUri, $HTTPMethod){
        if(!$requsetUri){
            throw new Exception('request uri must be not null, 400');
        }
        if(!$HTTPMethod){
            throw new Exception('http method must be not null, 400');
        }
        $url = parse_url($requsetUri, PHP_URL_PATH);
        $requestMethod = $HTTPMethod;

        foreach($this->routes as $route){
            
            $pattern = "@^".$route['pattern']."$@";
            if(preg_match($pattern, $url, $matches)){
                $matchedRoute = $route;
                $uriPathParams = $matches;
            }
        }
        if(!isset($matchedRoute) ){
            throw new Exception('that route doesnt exist, 400');
        }
        if($matchedRoute['req_method'] != $requestMethod){
            throw new Exception("matched route http method is not equal to actual http method, 405");
        }
        
        array_shift($uriPathParams);
        if(count($uriPathParams) >= 1){
            $command = $matchedRoute['command'];
            return $command->process($uriPathParams);
        }
        $command =  $matchedRoute['command'];
        return $command->process();

    }

 }



        
