<?php

class CategoryNameChangedResponseDto extends ResponseViewModel implements JsonSerializable{
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
    function jsonSerialize(): mixed
    {
        return ['success_message' => $this->getSuccessMessage()];
    }
}