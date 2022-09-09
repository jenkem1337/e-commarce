<?php
class CategoryDeletedResponseDto extends ResponseViewModel implements JsonSerializable {
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
    function jsonSerialize(): mixed
    {
        return ['success_message'=> $this->getSuccessfullMessage()];
    }
}