<?php

class ImageCreatedResponseDto extends ResponseViewModel implements JsonSerializable {
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
    function jsonSerialize(): mixed
    {
        return [
            'images' => $this->getImages()
        ];
    }
}