<?php

class ChangePasswordDto {
    protected $oldPassword;

    protected $newPassword;

    protected $email;

    public function __construct($email, $oldPassword, $newPassword)
    {
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
        $this->email = $email;
    }



    /**
     * Get the value of oldPassword
     */ 
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * Get the value of newPassword
     */ 
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }
}