<?php
require './vendor/autoload.php';
class AllUserResponseDto extends ResponseViewModel {
    protected ArrayIterator $users;
    public function __construct($users)
    {
        $this->users = $users;
        parent::__construct('success', $this);
    }




    public function getUsers()
    {
        return $this->users;
    }
}