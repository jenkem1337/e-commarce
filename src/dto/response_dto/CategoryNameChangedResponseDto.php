<?php
require './vendor/autoload.php';

class CategoryNameChangedResponseDto extends ResponseViewModel {
    private $successMessage;
    function __construct($successMessage)
    {
        $this->successMessage = $successMessage;
        parent::__construct('success', $this);
    }
    /**
     * Get the value of successMessage
     */ 
    public function getSuccessMessage()
    {
        return $this->successMessage;
    }
}