<?php 
header('Content-type: application/json');

require __DIR__. '/vendor/autoload.php';

$f = new FrontController();

$f->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);