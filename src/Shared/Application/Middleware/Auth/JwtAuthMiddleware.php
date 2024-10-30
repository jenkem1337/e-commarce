<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAuthMiddleware extends Middleware {
    function check():bool{
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        
            if(!$authHeader) throw new NullException("authorization header");
            
            $authorization = explode(' ', $authHeader);
            $jwt = $authorization[1];
            
            if(!$jwt) throw new DoesNotExistException('jwt token');
            
            $data = JWT::decode($jwt, new Key($_ENV['SECRET_KEY'], "HS256"));
            $jwtPayloadDto = JwtPayloadDto::getInstance();
            $jwtPayloadDto->setPayload($data);
            return parent::check();
        }
}