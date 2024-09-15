<?php
interface UploadService {
    function uploadNewProductImages(ArrayIterator $images, $productUuid);
    function deleteImageByUuid($imageName, $productUuid);
}