<?php

class RefreshTokenDto {
    protected $refreshToken;

    public function __construct($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }



    /**
     * Get the value of refreshToken
     */ 
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }
}