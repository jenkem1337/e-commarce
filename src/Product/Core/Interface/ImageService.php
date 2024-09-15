<?php

interface ImageService{
    function uploadImageForProduct(ImageCreationalDto $dto): ResponseViewModel;
    function deleteImageByUuid(DeleteImageByUuidDto $dto):ResponseViewModel;

}