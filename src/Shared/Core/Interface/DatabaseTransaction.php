<?php
interface DatabaseTransaction {
    function startTransaction();
    function commitTransaction();
    function rollbackTransaction();
}