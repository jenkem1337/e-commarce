<?php

interface OrderRepository {
    function saveChanges(Order $order);
    function findOneAggregateByUuid($uuid):OrderInterface;
    function findOneAggregateWithItemsByUuid($uuid): OrderInterface;
}