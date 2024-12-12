<?php

class FindAllOrderWithItemsByUserUuidDto{
    function __construct(private $userUuid){}

    /**
     * Get the value of userUuid
     */ 
    public function getUserUuid()
    {
        return $this->userUuid;
    }
}