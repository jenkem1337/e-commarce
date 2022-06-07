<?php 
header('Content-type: application/json');

require __DIR__. '/vendor/autoload.php';

$f = new FrontController();
$cont = new HelloWorldController();
$f->registerRoute("GET" ,"/HelloWorld", new HelloWorldndexCommand($cont));
$f->registerRoute("GET" ,"/SetNum/([0-9]+)/([0-9]+)", new HelloWorldSetNumCommand($cont));
$f->registerRoute("POST", "/register", new HelloWorldRegisterCommand($cont));
$f->registerRoute("POST", "/login", new HelloWorldLoginCommand($cont));

$f->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);