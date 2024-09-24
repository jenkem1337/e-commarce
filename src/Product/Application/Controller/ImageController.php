<?php

use Ramsey\Uuid\Uuid;

class ImageController {

    private ImageService $imageService;
    function __construct(ImageService $ImageService)
    {
        $this->imageService = $ImageService;
    }
    function uploadImageForProduct($productUuid){
        $imageArrayItarator = new ArrayIterator([]);
        $imageArr = [];
        foreach((array) $_FILES['images']['tmp_name'] as $k => $v){
            $imageArr['uuid']= Uuid::uuid4();
            $imageArr['productUuid'] = $productUuid;
            $imageArr['imageName'] = $_FILES['images']['name'][$k];
            $imageArr['imageTmpName'] = $_FILES['images']['tmp_name'][$k];
            $imageArr['createdAt'] =date ('Y-m-d H:i:s');
            $imageArr['updatedAt'] = date ('Y-m-d H:i:s');
            $imageObject = json_decode(json_encode($imageArr),false);
            $imageArrayItarator->append($imageObject);
        }
        $response = $this->imageService->uploadImageForProduct(new ImageCreationalDto($imageArrayItarator,$productUuid));
        echo json_encode($response);
        http_response_code(201);

    }
    function deleteImageByUuid($imageUuid, $productUuid){
        $response = $this->imageService->deleteImageByUuid(new DeleteImageByUuidDto($productUuid,$imageUuid));
        echo json_encode($response);
        http_response_code(201);
    }
}