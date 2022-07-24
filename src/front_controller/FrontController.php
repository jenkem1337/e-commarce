<?php

class FrontController {  
    
    private array $routes = [];
    function registerRoute(string $requestMethod,string $pattern, Command $cmd){
        
        $this->routes[] = ['req_method' => $requestMethod,'pattern' => $pattern, 'command' => $cmd];
    }
     
    function run($requsetUri, $HTTPMethod){
        if(!$requsetUri){
            throw new NullException('request uri');
        }
        if(!$HTTPMethod){
            throw new NullException('http method');
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
            throw new DoesNotExistException('route');
        }
        if($matchedRoute['req_method'] != $requestMethod){
            throw new HttpMethodException();
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



        
