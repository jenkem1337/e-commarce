<?php
require './src/front_controller/front_controller_command/Command.php';
require './vendor/autoload.php';
class HelloWorldController {
    public array $arr = [];
    
    function index(){
        echo json_encode(['hello' => 'world']);
    }
    function setNum(int $b,int $i){
        echo json_encode(
            [
                'birinici' => $b,
                'ikinci' => $i,
                'toplam' => $i+$b
            ]
        );
    }

    function register(){
        session_start();

        $jsonBody = json_decode(file_get_contents('php://input'), true);
        if(!isset($_SESSION['username'])){
            $_SESSION['username'] = $jsonBody['username'];
        }else{
            $_SESSION['username'] = $jsonBody['username'];

        }
        echo json_encode(['username' => (string) $_SESSION['username']]);

    }
    function login(){
        $jsonBody = json_decode(file_get_contents('php://input'),true);
        
        
        echo json_encode(['username' => (string) $_SESSION['username']]);

        
    }
}

class HelloWorldndexCommand implements Command{
    private $controller;
    function __construct($controller)
    {
        $this->controller = $controller;
    }
    function process($params = []){
        $this->controller->index();
    }
}
class HelloWorldSetNumCommand implements Command{
    private $controller;
    function __construct($controller)
    {
        $this->controller = $controller;
    }
    function process($params = []){
        if(isset($params[0]) && isset($params[1])){
            $this->controller->setNum((int)$params[0],(int)$params[1]);

        }
    }
}
class HelloWorldRegisterCommand implements Command{
    private $controller;
    function __construct($controller)
    {
        $this->controller = $controller;
    }
    function process($params = []){
        $this->controller->register();
    }
}

class UserLogedInMiddleware extends Middleware{
    function check():bool{
        $jsonBody = json_decode(file_get_contents('php://input'),true);

        if($_SESSION['username'] != $jsonBody['username']){
            http_response_code(401);
            echo json_encode(['error' => 'böyle biri yok']);
            exit;
            return false;
        }
        return parent::check();
    }
}
class HelloWorldLoginCommand implements Command{
    private $controller;
    function __construct($controller)
    {
        $this->controller = $controller;
    }
    function process($params = []){
        session_start();
        $m = new UserLogedInMiddleware();
        $m->check();
        $this->controller->login();
    }
}
