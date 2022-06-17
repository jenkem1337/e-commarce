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
        
        if(!$headers['Authorization']) throw new NullException("authorization header", 401);
        
        $authorization = explode(' ', $headers['Authorization']);
        $jwt = $authorization[1];
        
        if(!$jwt) throw new DoesNotExistException('jwt token', 401);
        
        $data = JWT::decode($jwt, new Key($_ENV['SECRET_KEY'], "HS256"));
        $jwtPayloadDto = JwtPayloadDto::getInstance();
        $jwtPayloadDto->setPayload($data);
        return parent::check();
    }
}