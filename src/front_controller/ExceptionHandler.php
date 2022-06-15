<?php

class ExceptionHandler {
    function handle(Exception $error){
        $splitedException = explode(', ', $error->getMessage());
        $message = $splitedException[0];
        $statusCode = $splitedException[1];
        if(!$statusCode) $statusCode = 500;
        echo json_encode([
            "error-message"=>$message,
            "status_code"=>$statusCode
        ]);
        http_response_code($statusCode);
        die();
    }
}