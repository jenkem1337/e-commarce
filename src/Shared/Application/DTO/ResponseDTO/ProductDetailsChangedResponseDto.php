<?php
class ProductDetailsChangedResponseDto extends ResponseViewModel implements JsonSerializable {
    protected $succesMessage;

    public function __construct($succesMessage)
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

    function jsonSerialize(): mixed
    {
        return ['success_message' => $this->getSuccesMessage()];
    }
}