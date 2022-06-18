<?php

class ExceptionHandler {
    function handle(Exception $error){
        if($error->getCode()<400) $error->code = 500;
        echo json_encode([
            "error_message"=>$error->getMessage(),
            "status_code"=>$error->getCode()
        ]);
        http_response_code($error->getCode());
        die();
    }
}