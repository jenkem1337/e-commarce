<?php

class UploadServiceImpl implements UploadService {
    function uploadNewProductImages(ArrayIterator $images, $productUuid)
    {
        if(!file_exists($_SERVER['DOCUMENT_ROOT']."/src/uploads/products/$productUuid")){
            mkdir($_SERVER['DOCUMENT_ROOT']."/src/uploads/products/$productUuid", 0777, true);
        }
        foreach($images as $image){
            $imageName = $image->imageName;
            $targetFile = $_SERVER['DOCUMENT_ROOT']."/src/uploads/products/$productUuid/$imageName";
            move_uploaded_file($image->imageTmpName, $targetFile);
        }
    }
    function deleteImageByUuid($imageName, $productUuid)
    {
        if(!file_exists($_SERVER['DOCUMENT_ROOT']."/src/uploads/products/$productUuid")){
            throw new DoesNotExistException('product image folder');
        }
        if(!unlink($_SERVER['DOCUMENT_ROOT']."/src/uploads/products/$productUuid/$imageName")){
            throw new DoesNotExistException('product image file');
        }
        unlink($_SERVER['DOCUMENT_ROOT']."/src/uploads/products/$productUuid/$imageName");
    }
}