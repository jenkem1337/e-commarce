<?php
interface BaseEntityInterface {
    function getUuid();
    function getCreatedAt();
    function getUpdatedAt();
    function isNull():bool;
}