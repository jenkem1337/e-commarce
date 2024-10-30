<?php
class NullPeyment implements PeymentInterface, NullEntityInterface {
    function processPeyment(PeymentCommand $peymentCommand){}
    function getUserUuid() {}
    function getAmount() {}
    function getMethod() {}
    function getStatus() {}
    function getCreatedAt(){}
    function getUpdatedAt() {}
    function getUuid(){}
    function isNull(): bool{
        return true;
    }
}