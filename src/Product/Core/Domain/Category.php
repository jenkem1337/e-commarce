<?php
class Category extends BaseEntity implements AggregateRoot, CategoryInterface{
    private $categoryName;
    private $productUuid;
    function __construct($uuid, $categoryName, $createdAt, $updatedAt)
    {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$categoryName) throw new NullException('category name');
        $this->categoryName = $categoryName;
    }
    public static function newInstance($uuid, $categoryName, $createdAt, $updatedAt):CategoryInterface {
        try {
            return new Category($uuid, $categoryName, $createdAt, $updatedAt);
        } catch (\Throwable $th) {
            return new NullCategory();
        }
    }

    public static function newStrictInstance($uuid, $categoryName, $createdAt, $updatedAt):CategoryInterface {
        return new Category($uuid, $categoryName, $createdAt, $updatedAt);
    }

    public static function newInstanceWithInsertLog($uuid, $categoryName, $createdAt, $updatedAt):CategoryInterface {
        $category = new Category($uuid, $categoryName, $createdAt, $updatedAt);
        $category->appendLog(new InsertLog("categories", [
            "uuid" => $category->getUuid(),
            "category_name" => $category->getCategoryName(),
            "created_at" => $category->getCreatedAt(),
            "updated_at" => $category->getUpdatedAt()
        ]));
        return $category;
    }

    function changeCategoryName($categoryName){
        if(!$categoryName) throw new NullException('new category name');
        if($categoryName == $this->categoryName) throw new SamePropertyException('new category name', 'category name');
        $this->categoryName = $categoryName;
        $this->appendLog(new UpdateLog("categories", [
            "setter" => [
                "category_name" => $this->categoryName
            ],
            "whereCondation" => [
                "uuid" => $this->getUuid()
            ]
        ]));
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