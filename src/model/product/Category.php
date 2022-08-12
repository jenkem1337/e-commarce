<?php
class Category extends BaseEntity implements CategoryInterface{
    private $categoryName;
    private $productUuid;
    function __construct($uuid, $categoryName, $createdAt, $updatedAt)
    {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$categoryName) throw new NullException('category name');
        $this->categoryName = $categoryName;
    }
    function changeCategoryName($categoryName){
        if(!$categoryName) throw new NullException('new category name');
        if($categoryName == $this->categoryName) throw new SamePropertyException('new category name', 'category name');
        $this->categoryName = $categoryName;

    }

    /**
     * Get the value of categoryName
     */ 
    public function getCategoryName()
    {
        return $this->categoryName;
    }

	function getProductUuid() {
		return $this->productUuid;
	}
	
	function setProductUuid($productUuid): void {
        if(!$productUuid) throw new NullException('product uuid');
		$this->productUuid = $productUuid;
	}
}