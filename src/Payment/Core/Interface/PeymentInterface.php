<?php
interface PeymentInterface {
    function processPeyment(PeymentCommand $peymentCommand);
    function getUserUuid() ;
    function getAmount() ;
    function getMethod() ;
    function getStatus() ;
}