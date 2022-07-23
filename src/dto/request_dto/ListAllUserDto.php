<?php

class ListAllUserDto {
    protected $perPageForUser;

    protected $pageNum;

    protected $startingLimit;

    public function __construct($perPageForUser, $pageNum)
    {
        $this->perPageForUser = $perPageForUser;
        $this->pageNum = $pageNum;
        $this->startingLimit = ($this->pageNum-1)*$this->perPageForUser;
    }



    /**
     * Get the value of startingLimit
     */ 
    public function getStartingLimit()
    {
        return $this->startingLimit;
    }

    /**
     * Get the value of pageNum
     */ 
    public function getPageNum()
    {
        return $this->pageNum;
    }

    /**
     * Get the value of perPageForUser
     */ 
    public function getPerPageForUser()
    {
        return $this->perPageForUser;
    }
}