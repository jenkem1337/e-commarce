<?php

class EmailVerificationDto {
    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
    }



    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }
}