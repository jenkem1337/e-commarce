<?php

interface ImageRepository {
    function persist(Image $i);
    function deleteByUuid($uuid);
    function findAll():IteratorAggregate;
    function findImageByProductUuid($pUuid):ImageInterface;
    function findOneByUuid($uuid): ImageInterface;

}