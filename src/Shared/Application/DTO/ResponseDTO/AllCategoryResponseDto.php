<?php

class AllCategoryResponseDto extends ResponseViewModel implements JsonSerializable {
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
    function jsonSerialize(): mixed
    {
        $response = [];
        foreach($this->getCategories() as $category){
            $response[] = [
                'uuid' => $category->getUuid(),
                'category_name' => $category->getCategoryName(),
                'created_at' => $category->getCreatedAt(),
                'updated_at' => $category->getUpdatedAt()
            ];
        }
        return $response;

    }
}