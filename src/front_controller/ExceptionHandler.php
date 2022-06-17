<?php

class ExceptionHandler {
    function handle(Exception $error){
        echo json_encode([
            "error_message"=>$error->getMessage(),
            "status_code"=>$error->getCode()
        ]);
        http_response_code($error->getCode());
        die();
    }
}