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
        $this->imageService->uploadImageForProduct(new ImageCreationalDto($imageArrayItarator,$productUuid))
            ->onSucsess(function (ImageCreatedResponseDto $responseDto){
                echo json_encode($responseDto);
            
            })->onError(function (ErrorResponseDto $err){
                echo json_encode($err);    
                http_response_code($err->getErrorCode());
            });
        
    }
    function deleteImageByUuid($imageUuid, $productUuid){
        $this->imageService->deleteImageByUuid(new DeleteImageByUuidDto($productUuid,$imageUuid))
                        ->onSucsess(function (ImageDeletedResponseDto $response){
                            echo json_encode($response);
                        })->onError(function (ErrorResponseDto $err){
                            echo json_encode($err);    
                            http_response_code($err->getErrorCode());
                        });
    }
}