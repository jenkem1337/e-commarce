<?php

interface ImageDao {
    function persist(Image $i);
    function deleteByUuid($uuid);
    function findAll();
    function findImageByProductUuid($pUuid);
    function findOneByUuid($uuid);
    
}