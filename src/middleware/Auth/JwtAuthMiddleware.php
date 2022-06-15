<?php
require "./vendor/autoload.php";
use Ramsey\Uuid\Nonstandard\Uuid;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv\Dotenv::createImmutable("C:\\xampp\htdocs\\");
$dotenv->load();

class JwtAuthMiddleware extends Middleware {
    function check():bool{

        $headers = apache_request_headers();
        
        if(!$headers['Authorization']) throw new Exception("authorization header null, 401");
        
        $authorization = explode(' ', $headers['Authorization']);
        $jwt = $authorization[1];
        
        if(!$jwt) throw new Exception('jwt token doesnt exist, 401');
        
        $data = JWT::decode($jwt, new Key($_ENV['SECRET_KEY'], "HS256"));
        $jwtPayloadDto = JwtPayloadDto::getInstance();
        $jwtPayloadDto->setPayload($data);
        return parent::check();
    }
}