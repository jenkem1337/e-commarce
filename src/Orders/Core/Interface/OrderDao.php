<?php

interface OrderDao extends SaveChangesInterface, DatabaseTransaction{
    function findOneByUuid($uuid);
    function findAllItemsByOrderUuid($orderUuid);
}