<?php

class FrontController {  
    
    private array $routes = [];

    function registerRoute(string $requestMethod,string $pattern, Command $cmd){
        
        $this->routes[] = ['req_method' => $requestMethod,'pattern' => $pattern, 'command' => $cmd];
    }

    function run($requsetUri, $HTTPMethod){
        if(!$requsetUri){
            throw new Exception('request uri must be not null');
        }
        if(!$HTTPMethod){
            throw new Exception('http method must be not null');
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
            throw new Exception('that route doesnt exist');
        }
        if($matchedRoute['req_method'] != $requestMethod){
            throw new Exception("matched route http method is not equal to actual http method");
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



        
