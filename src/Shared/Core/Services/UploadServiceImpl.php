<?php

class UploadServiceImpl implements UploadService {
    private ObjectStorageConnection $objectStorage;
    function __construct(ObjectStorageConnection $objectStorage) {
        $this->objectStorage = $objectStorage;
    }
    function uploadNewProductImages($images, $productUuid)
    {
        $objectStorageConnection = $this->objectStorage->getConnection();

        for($i = 0; $i < count($images["tmp_name"]); $i++){
            
            $objectStorageConnection->putObject([
                "Bucket" => "image",
                "Key" => $productUuid."/".$images["name"][$i],
                "SourceFile" => $images['tmp_name'][$i]  
            ]);
        }
    }
    function deleteOneImageByUuid($location)
    {
        $objectStorageConnection = $this->objectStorage->getConnection();

            
            $result = $objectStorageConnection->deleteObject([
                "Bucket" => "image",
                "Key" => $location  
            ]);
            
            if($result["DeleteMarker"]){
                throw new Exception("Image was not deleted");
            }
    }
}