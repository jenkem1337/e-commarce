<?php
class SuccessResponse implements ResponseViewModel, JsonSerializable{
    private array $data;
    function __construct($data){
        $this->data = $data;
    }
    
    function jsonSerialize():mixed {
        return  $this->data;
    }

    /**
     * Get the value of data
     */ 
    public function getData(): array
    {
        return $this->data;
    }
}