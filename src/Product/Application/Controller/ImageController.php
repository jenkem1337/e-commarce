<?php

use Ramsey\Uuid\Uuid;

class ImageController {

    private ImageService $imageService;
    function __construct(ImageService $ImageService)
    {
        $this->imageService = $ImageService;
    }
    function uploadImageForProduct($productUuid){
        
        if(!isset($_FILES["images"])) {
            throw new DoesNotExistException("image files");
        }
        
        $images = $_FILES['images'];
        $response = $this->imageService->uploadImageForProduct(new ImageCreationalDto($images,$productUuid));
        echo json_encode($response);
        http_response_code(201);

    }
    function deleteImageByUuid($imageUuid, $productUuid){
        $response = $this->imageService->deleteImageByUuid(new DeleteImageByUuidDto($productUuid,$imageUuid));
        echo json_encode($response);
        http_response_code(201);
    }
}