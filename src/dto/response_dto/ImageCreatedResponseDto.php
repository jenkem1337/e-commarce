<?php
require './vendor/autoload.php';

class ImageCreatedResponseDto extends ResponseViewModel {
    protected $images;

    public function __construct($images)
    {
        $this->images = $images;
        parent::__construct('success',$this);
    }

    

    /**
     * Get the value of images
     */ 
    public function getImages()
    {
        return $this->images;
    }
}