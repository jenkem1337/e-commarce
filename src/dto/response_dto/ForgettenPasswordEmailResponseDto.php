<?php

class ForgettenPasswordEmailResponseDto extends ResponseViewModel {

    protected $succesMessage;

    public function __construct( $succesMessage)
    {
        $this->succesMessage = $succesMessage;
        parent::__construct('success', $this);
    }



    /**
     * Get the value of succesMessage
     */ 
    public function getSuccesMessage()
    {
        return $this->succesMessage;
    }

}