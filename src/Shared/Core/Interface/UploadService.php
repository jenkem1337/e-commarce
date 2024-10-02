<?php
interface UploadService {
    function uploadNewProductImages($images, $productUuid);
    function deleteOneImageByUuid($location);
}