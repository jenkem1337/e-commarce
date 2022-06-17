<?php 
require "./vendor/autoload.php";

class IsAdminMiddleware extends Middleware {
    function check(): bool
    {
        $jwtPayloadDto = JwtPayloadDto::getInstance();
        $payload = $jwtPayloadDto->getPayload();
        if($payload->user_role !== "ADMIN"){
            throw new UserRoleException('admin');
            die();
        }
        return parent::check();
    }
}