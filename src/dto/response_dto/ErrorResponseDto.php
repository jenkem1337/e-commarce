<?php

class ErrorResponseDto extends ResponseViewModel {
    private $errorMessage;
    private $errorCode;

    function __construct($errMsg, $errorCode)
    {
        $this->errorMessage = $errMsg;
        $this->errorCode = $errorCode;
        parent::__construct('error', $this);
    }

    /**
     * Get the value of errorMessage
     */ 
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Get the value of errorCode
     */ 
    public function getErrorCode()
    {
        return $this->errorCode;
    }
}