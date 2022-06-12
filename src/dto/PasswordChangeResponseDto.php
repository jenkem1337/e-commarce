<?php
class PasswordChangeResponseDto {
    protected $isSuccess;

    protected $succesMessage;

    public function __construct($isSuccess, $succesMessage)
    {
        $this->isSuccess = $isSuccess;
        $this->succesMessage = $succesMessage;
    }



    /**
     * Get the value of isSuccess
     */ 
    public function isSuccess()
    {
        return $this->isSuccess;
    }

    /**
     * Get the value of succesMessage
     */ 
    public function getSuccesMessage()
    {
        return $this->succesMessage;
    }
}