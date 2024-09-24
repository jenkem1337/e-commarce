<?php
class SuccessResponse implements ResponseViewModel, JsonSerializable{
    private array $data;
    function __construct($data){
        $this->data = $data;
    }
    function jsonSerialize():mixed {
        return  $this->data;
    }
}