<?php

class ForgettenPasswordDto {

    protected $verificitationCode;

    protected $newPassword;

    public function __construct($verificitationCode, $newPassword)
    {
        $this->verificitationCode = $verificitationCode;
        $this->newPassword = $newPassword;
    }



    /**
     * Get the value of verificitationCode
     */ 
    public function getVerificitationCode()
    {
        return $this->verificitationCode;
    }

    /**
     * Get the value of newPassword
     */ 
    public function getNewPassword()
    {
        return $this->newPassword;
    }

}