<?php
require './vendor/autoload.php';
class CategoryDeletedResponseDto extends ResponseViewModel {
    protected $successfullMessage;

    public function __construct($successfullMessage)
    {
        $this->successfullMessage = $successfullMessage;
        parent::__construct('success', $this);
    }

    /**
     * Get the value of successfullMessage
     */ 
    public function getSuccessfullMessage()
    {
        return $this->successfullMessage;
    }
}