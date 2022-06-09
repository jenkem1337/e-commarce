<?php 

class EmailSuccessfulyActivatedResponseDto {
    protected $fullname;

    protected $email;
    
    protected $isUserActivaed;

    protected $created_at;

    protected $updated_at;

    protected $uuid;

    protected $isSuccess;

    public function __construct($isSuccess,$uuid,$fullname, $email, $isUserActivaed, $created_at, $updated_at)
    {
        $this->isSuccess = $isSuccess;
        $this->uuid = $uuid;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->isUserActivaed = $isUserActivaed;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }



    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Get the value of uuid
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Get the value of isUserActivaed
     */ 
    public function getIsUserActivaed()
    {
        return $this->isUserActivaed;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of fullname
     */ 
    public function getFullname()
    {
        return $this->fullname;
    }

    public function isSuccess()
    {
        return $this->isSuccess;
    }
}
