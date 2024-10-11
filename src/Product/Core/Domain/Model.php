<?php
class Model extends BaseEntity implements ModelInterface {
    private $name;
    private $brandUuid;
    function __construct($uuid, $name, $brandUuid,$createdAt, $updatedAt) {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$name) throw new NullException("name");
        if(strlen(trim($name)) == 0) throw new NullException("name");
        if(!$uuid) throw new NullException("uuid");
        $this->name = $name;
        $this->brandUuid = $brandUuid; 
    }


    static function newInstance($uuid, $name, $brandUuid,$createdAt, $updatedAt):ModelInterface {
        try {
            return new Model($uuid, $name, $brandUuid,$createdAt, $updatedAt);
        } catch (\Throwable $th) {
            return new NullModel();
        }
    }
    static function newStrictInstance($uuid, $name, $brandUuid,$createdAt, $updatedAt):ModelInterface {
        return new Model($uuid, $name, $brandUuid,$createdAt, $updatedAt);
    }

    function changeName($name){
        if(!$name) throw new NullException("name");
        if(strlen(trim($name)) == 0) throw new NullException("name");
        $this->name = $name;
    }

    function getName() {
        return $this->name;
    }

    function getBrandUuid(){
        return $this->brandUuid;
    }

}