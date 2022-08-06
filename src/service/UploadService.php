<?php
interface UploadService {
    function uploadNewProductImages(array $images, $productUuid);
}