<?php
require './vendor/autoload.php';

class AllCategoryResponseDto extends ResponseViewModel {
    private ArrayIterator $categories;
    function __construct(ArrayIterator $categories)
    {
        $this->categories = $categories;
        parent::__construct('success', $this);
    }

    /**
     * Get the value of categories
     */ 
    public function getCategories()
    {
        return $this->categories;
    }
}