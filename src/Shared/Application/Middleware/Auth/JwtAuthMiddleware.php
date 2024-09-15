<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAuthMiddleware extends Middleware {
    function check():bool{
            $headers = apache_request_headers();
        
            if(!$headers['Authorization']) throw new NullException("authorization header");
            
            $authorization = explode(' ', $headers['Authorization']);
            $jwt = $authorization[1];
            
            if(!$jwt) throw new DoesNotExistException('jwt token');
            
            $data = JWT::decode($jwt, new Key($_ENV['SECRET_KEY'], "HS256"));
            $jwtPayloadDto = JwtPayloadDto::getInstance();
            $jwtPayloadDto->setPayload($data);
            return parent::check();
        }
}