<?php
class AllUserResponseDto extends ResponseViewModel implements JsonSerializable{
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

    function jsonSerialize(): mixed
    {
        $response = [];
        foreach($this->getUsers() as $user){
            $response[] = [
                "uuid"=>$user->getUuid(),
                "full_name"=>$user->getFullname(),
                "email"=>$user->getEmail(),
                "password"=>$user->getPassword(),
                "user_role"=>$user->getUserRole(),
                "is_user_activated"=>$user->getIsUserActiveted(),
                "created_at"=>$user->getCreatedAt(),
                "updated_at"=>$user->getUpdatedAt()
            ];
       }
       return $response;

    }
}