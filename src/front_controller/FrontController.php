<?php

class FrontController {  
    
    private array $routes = [];

    function registerRoute(string $requestMethod,string $pattern, Command $cmd){
        
        $this->routes[] = ['req_method' => $requestMethod,'pattern' => $pattern, 'command' => $cmd];
    }

    function run($requsetUri, $HTTPMethod){
        $url = $requsetUri;
        $requestMethod = $HTTPMethod;

        foreach($this->routes as $route){

            $p = "@^".$route['pattern']."$@";
            if(preg_match($p, $url, $matches)){
                $matchedRoute = $route;
                $uriPathParams = $matches;
            }
        }

        if($matchedRoute['req_method'] != $requestMethod){
            throw new Exception("Hatalı HTTP metodu");
        }
        
        array_shift($uriPathParams);
        if(count($uriPathParams) >= 1){
            $command = $matchedRoute['command'];
            $command->process($uriPathParams);
        }
        $command =  $matchedRoute['command'];
        $command->process();

    }

 }



        
