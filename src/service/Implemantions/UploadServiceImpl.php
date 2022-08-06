<?php
require './vendor/autoload.php';

class UploadServiceImpl implements UploadService {
    function uploadNewProductImages(array $images, $productUuid)
    {
        if(!file_exists(__DIR__."/src/uploads/products/$productUuid")){
            mkdir(__DIR__."/src/uploads/products/$productUuid");
        }
        for($i = 0; $i<count($images['name']); $i++){
            $imageName = $images['name'][$i];
            $targetFile = __DIR__."/src/uploads/products/$productUuid/$imageName";

            move_uploaded_file($images['tmp_name'][$i], $targetFile);
        }
    }
}