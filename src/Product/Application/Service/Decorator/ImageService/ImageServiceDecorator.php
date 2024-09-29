<?php

abstract class ImageServiceDecorator implements ImageService{
    private ImageService $imageService;
    function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    function uploadImageForProduct(ImageCreationalDto $dto): ResponseViewModel
    {
        return $this->imageService->uploadImageForProduct($dto);
    }
    function deleteImageByUuid(DeleteImageByUuidDto $dto): ResponseViewModel
    {
        return $this->imageService->deleteImageByUuid($dto);
    }
}