<?php
class SuccessResponse implements JsonSerializable{
    private array $data;
    function __construct($data){
        $this->data = $data;
    }
    function jsonSerialize():mixed {
        return  $this->data;
    }
}