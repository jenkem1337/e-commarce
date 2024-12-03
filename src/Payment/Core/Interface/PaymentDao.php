<?php

interface PaymentDao extends SaveChangesInterface, DatabaseTransaction{
    function findOneByUuid($uuid);
}