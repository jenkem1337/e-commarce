<?php

interface ImageRepository {
    function persist(Image $i);
    function deleteByUuid($uuid);
    function findAll():ArrayIterator;
    function findImageByProductUuid($pUuid):ImageInterface;
    function findOneByUuid($uuid): ImageInterface;

}