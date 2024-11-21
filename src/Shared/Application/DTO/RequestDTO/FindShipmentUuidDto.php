<?
class FindShipmentUuidDto {
    function __construct(
        private $type
    ){}

    function getType(){
        return $this->type;
    }
}